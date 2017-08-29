@extends('layouts.app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-3">
					<h4>#Hashtags</h4>
				</div>
				<div class="col-md-8">
					<form class="form-inline" method="GET" action="{{ action('TwitterController@hashtaglist') }}">
						<div class="form-group">
							<input type="text" class="form-control" name="hashtag" value="" placeholder="#Hashtag" size="32">
						</div>
						<input type="submit" class="btn btn-primary btn-sm" value="Buscar">
					</form>
				</div>

			</div>
		</div>

		<div class="panel-body">			
			<table class="table">
				<thead>
					<tr>
						<th>Hashtag</th>
						<th>Criação</th>
						<th>Opções</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($hashtags as $hashtag)
						<tr>
							<td>{{ $hashtag->name }}</td>
							<td>{{ Util::displayDateTimePTBR($hashtag->created_at) }}</td>
							<td>
								<a class="btn btn-success btn-sm" href="{{ url('twitter/hashtaghistory/' . $hashtag->id)}}">Histórico</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>	
		</div>
	</div>

	<script type="text/javascript">
		$(function() {
			$("#menu_history").addClass("active");
		});
	</script>
@endsection