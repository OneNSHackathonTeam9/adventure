@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<a class="btn btn-default pull-right"
				style="margin: 10px;"
				href="<?php echo action('StoryController@restart', ['lemonstand']); ?>">
					Restart
			</a>
			<div class="panel panel-default">
				<form method="post">
				<div class="panel-heading"><h2><?php echo $name; ?></h2></div>

				@if (Session::has('flash_notification.message'))
				    <div class="alert alert-{{ Session::get('flash_notification.level') }}"
					style="margin: 10px;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

					{{ Session::get('flash_notification.message') }}
				    </div>
				@endif

				<div class="panel-body">
					<div>
						<?php echo $scenario; ?>
					</div>
					<?php foreach($answers as $answer) { ?>
					<div class="radio">
					  <label>
					    <input type="hidden" name="scenario" value="<?php echo $id;?>" />
					    <input type="radio" name="answer"
						id="answer<?php echo $answer->id;?>"
						value="<?php echo $answer->id;?>" checked>
							<?php echo $answer->answer;?>
					  </label>
					</div>
					<?php } ?>
					<?php if(!$done) { ?>
						<input class="btn btn-info pull-right" type="submit" value="Go!">
					<?php } else { ?>
					<a class="btn btn-success pull-right"
						style="margin: 10px;"
						href="<?php echo action('StoryController@restart', ['lemonstand']); ?>">
							Start Over
					</a>
					<?php } ?>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
