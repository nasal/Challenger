<style>
	label { margin-top: 5px; }
</style>
<h1 class="header">Create challenge</h1>
<form method="post">
	<div class="row-fluid"><div class="span2"><label>Category:<label></div><div class="span10"><select name="game_type"><? $q = pg_query("select * from game_type order by name asc"); while ($f = pg_fetch_assoc($q)) { echo '<option value="' . $f['gt_id'] . '">' . $f['name'] . '</option>'; } ?></select></div></div>
	<div class="row-fluid"><div class="span2"><label>Title:<label></div><div class="span10"><input type="text" name="title" placeholder="Challenge name"></div></div>
	<div class="row-fluid"><div class="span2"><label>Description:<label></div><div class="span10"><textarea style="width: 95%; height: 70px;" name="description"></textarea></div></div>
	<input type="submit" value="Create challenge" name="create_challenge" class="btn btn-primary">
</form>