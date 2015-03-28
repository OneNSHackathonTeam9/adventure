@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo $name; ?></div>
				<div class="panel-body">
					@if (Session::has('flash_notification.message'))
					    <div class="alert alert-{{ Session::get('flash_notification.level') }}"
						 style="margin: 10px;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{{ Session::get('flash_notification.message') }}
					    </div>
					@endif
Welcome to Citroni – the first text-based entrepreneurial adventure, in the tradition of the classic Choose Your Own Adventure genre.<br/><br/>
Who should you hire for what roles? Should you pursue quality or quantity? Do you sell your business, or pursue it forever? These are the hard questions you’ll be answering in Citroni. To succeed, you’ll need to be smart, dedicated, and a little lucky. And remember: failure is often merely a path to victory.</br></br>
					<form method="post">
						<div class="row">
						<div class="form-group col-lg-6 ">
						    <label for="business">Business Name</label>
						    <input type="text" class="form-control" name="business" id="business" placeholder="First choose a name for your business..." />
						</div>
						</div>
						<input class="btn btn-info pull-right" type="submit" value="Go!">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
