<h2><?= $title ?></h2>
<?php foreach($posts as $post) : ?>
	<h3><?php echo $post['title']; ?></h3>
	<div class="row">
		<div class="col-md-9">
			<small class="post-date">Posted on: <?php echo $post['created_at']; ?> in </strong></small> 
		<?php echo word_limiter($post['body'], 60); ?>
		<p><a class="btn btn-default" href="<?php echo site_url('/posts/'.$post['id']); ?>">Read More</a></p>
		</div>
	</div>
<?php endforeach; ?>