<footer class="main-footer">
	<?php if (ENVIRONMENT=='development'): ?>
		<div class="pull-right hidden">
			CI Bootstrap Version: <strong><?php echo CI_BOOTSTRAP_VERSION; ?></strong>, 
			CI Version: <strong><?php echo CI_VERSION; ?></strong>, 
			Elapsed Time: <strong>{elapsed_time}</strong> seconds, 
			Memory Usage: <strong>{memory_usage}</strong>
		</div>
	<?php endif; ?>
	Copyright <strong>Điểm Nhấn Group</strong> &copy; <?php echo date('Y'); ?>
</footer>
