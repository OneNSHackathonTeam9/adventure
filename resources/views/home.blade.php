@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<!--<div class="panel-body">
					You are logged in!-->
					<ul class="list-group">
						<a href="story/lemonstand" class="list-group-item">
							<span class="badge">new</span>
							Lemonade Stand
						</a>
						<a href="#" class="list-group-item">
							<span class="badge">Day 2</span>
							Lean Startup	
						</a>
						<a href="#" class="list-group-item">
							<span class="badge">Day 3</span>
							Executive	
						</a>
					</ul>
				<!--</div>-->
			</div>
		</div>
	</div>
</div>
@endsection
