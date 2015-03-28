@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Stories</div>

				<!--<div class="panel-body">
					You are logged in!-->
					<ul class="list-group">
						<a href="first/lemonstand" class="list-group-item">
							<span class="badge">
							<?php if(Session::has('current')) {
								echo 'in progress';
							} else {
								echo 'new';
							}?>
							</span>
							Lemonade Stand
						</a>
						<a href="#" class="list-group-item">
							<span class="badge">in progress</span>
							Lean Startup	
						</a>
						<a href="#" class="list-group-item">
							<span class="badge">new</span>
							Executive	
						</a>
					</ul>
				<!--</div>-->
			</div>
		</div>
	</div>
</div>
@endsection
