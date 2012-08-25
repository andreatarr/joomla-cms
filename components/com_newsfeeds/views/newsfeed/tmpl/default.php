<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_newsfeeds
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php
if (!empty($this->msg))
{
	echo $this->msg;
}
else
{
	$lang = JFactory::getLanguage();
	$myrtl = $this->newsfeed->rtl;
	$direction = " ";

		if ($lang->isRTL() && $myrtl == 0)
		{
			$direction = " redirect-rtl";
		}
		elseif ($lang->isRTL() && $myrtl == 1)
		{

				$direction = " redirect-ltr";
		}
		elseif ($lang->isRTL() && $myrtl == 2)
		{
			$direction = " redirect-rtl";
		}
		elseif ($myrtl == 0)
		{
			$direction = " redirect-ltr";
		}
		elseif ($myrtl == 1)
		{
			$direction = " redirect-ltr";
		}
		elseif ($myrtl == 2)
		{
			$direction = " redirect-rtl";
		}
$images  = json_decode($this->item->images);
	?>
	<div class="newsfeed<?php echo $this->pageclass_sfx?><?php echo $direction; ?>">
	<?php if ($this->params->get('display_num')) :  ?>
	<h1 class="<?php echo $direction; ?>">
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>
	<h2 class="<?php echo $direction; ?>">
		<a href="<?php echo $this->item->link; ?>" target="_blank">
		<?php echo str_replace('&apos;', "'", $this->item->name); ?></a>
	</h2>
	<!-- Show Images from Component -->
	<?php  if (isset($images->image_intro) and !empty($images->image_intro)) : ?>
	<?php $imgfloat = (empty($images->float_intro)) ? $this->params->get('float_intro') : $images->float_intro; ?>
	<div class="img-intro-<?php echo htmlspecialchars($imgfloat); ?>"> <img
		<?php if ($images->image_intro_caption):
			echo 'class="caption"'.' title="' .htmlspecialchars($images->image_intro_caption) .'"';
		endif; ?>
		src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/> </div>
	<?php endif; ?>

	<?php  if (isset($images->image_fulltext) and !empty($images->image_fulltext)) : ?>
	<?php $imgfloat = (empty($images->float_fulltext)) ? $this->params->get('float_fulltext') : $images->float_fulltext; ?>
	<div class="pull-<?php echo htmlspecialchars($imgfloat); ?> item-image"> <img
	<?php if ($images->image_fulltext_caption):
		echo 'class="caption"'.' title="' .htmlspecialchars($images->image_fulltext_caption) .'"';
	endif; ?>
	src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>"/> </div>
	<?php endif; ?>
	<!-- Show Description from Component -->
<?php echo $this->item->description; ?>
	<!-- Show Feed's Description -->

	<?php if ($this->params->get('show_feed_description')) : ?>
		<div class="feed-description">
			<?php echo str_replace('&apos;', "'", $this->rssDoc->description); ?>
		</div>
	<?php endif; ?>

	<!-- Show Image -->
	<?php if (isset($this->rssDoc->image) && isset($this->rssDoc->imagetitle) && $this->params->get('show_feed_image')) : ?>
	<div>
			<img src="<?php echo $this->rssDoc->image; ?>" alt="<?php echo $this->rssDoc->image->decription; ?>" />
</div>
<?php endif; ?>

	<!-- Show items -->
	<?php if (!empty($this->rssDoc[0])){ ?>
	<ol>
		<?php for ($i = 0; $i < $this->item->numarticles; $i++) {  ?>

	<?php
		$uri = !empty($this->rssDoc[$i]->guid) || !is_null($this->rssDoc[$i]->guid) ? $this->rssDoc[$i]->guid : $this->rssDoc[$i]->uri;
		$uri = substr($uri, 0, 4) != 'http' ? $this->item->link : $uri;
		$text = !empty($this->rssDoc[$i]->content) ||  !is_null($this->rssDoc[$i]->content) ? $this->rssDoc[$i]->content : $this->rssDoc[$i]->description;
	?>
			<li>
				<?php if (!empty($uri)) : ?>
					<a href="<?php echo $uri; ?>" target="_blank">
					<?php  echo $this->rssDoc[$i]->title; ?></a>
				<?php else : ?>
					<h3><?php  echo $this->rssDoc[$i]->title; ?></h3>
				<?php  endif; ?>
				<?php if ($this->params->get('show_item_description') && !empty($text)) : ?>
					<div class="feed-item-description">
					<?php if($this->params->get('show_feed_image', 0) == 0)
					{
						$text = JFilterOutput::stripImages($text);
					}
					$text = JHtml::_('string.truncate', $text, $this->params->get('feed_character_count'));
						echo str_replace('&apos;', "'", $text);
					?>

					</div>
				<?php endif; ?>
				</li>
			<?php } ?>
			</ol>
		<?php } ?>
	</div>
<?php } ?>
