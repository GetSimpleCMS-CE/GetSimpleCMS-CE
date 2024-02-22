<?php include('header.inc.php'); ?>

<section class="content">
	<div class="container">
		<div class="content-grid 
		<?php if ($defaultGrid == 'left') {
			echo 'content-grid-left';
		} elseif ($defaultGrid  == 'without') {
			echo 'content-grid-nosidebar';
		}; ?>
		">
			<main class="content-main">

				<hgroup class="content-title">
					<h1><?php get_page_title(); ?></h1>

					<nav aria-label="breadcrumb">

						<ul>
							<li><a href="<?php get_site_url(); ?>"><?php get_site_name(); ?></a></li>
							<li><a href="<?php get_site_url(); ?>"><?php get_page_title(); ?></a></li>
						</ul>

					</nav>
				</hgroup>

 
				<?php get_page_content(); ?>
			</main>
			<aside class="content-sidebar">
				<?php get_component('sidebar'); ?>
				<?php get_component('tagline'); ?>
			</aside>

		</div>
	</div>
</section>

<?php include('footer.inc.php'); ?>