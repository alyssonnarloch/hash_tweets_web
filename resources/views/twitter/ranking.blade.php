@extends('layouts.app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>#Ranking</h4>
		</div>

		<div class="panel-body">
			<div class="row">
				
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>Nº</th>
						<th>Hashtag</th>
						<th>Tweets</th>
						<th>Última busca</th>
						<th>Opções</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($hashtags as $position => $hashtag)
						<tr class="{{ ($position == 0) ? 'bg-primary' : '' }}">
							<td>{{ $position + 1 }}</td>
							<td>{{ $hashtag->name }}</td>
							<td>{{ $hashtag->tweet_count }}</td>
							<td>{{ Util::displayDateTimePTBR($hashtag->created_at) }}</td>
							<td>
								<a class="btn btn-{{ ($position == 0) ? 'default' : 'success' }} btn-sm" href="{{ url('twitter/history/' . $hashtag->hashtag_id)}}">Histórico</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>	
		</div>
	</div>

	<script type="text/javascript">
		$(function() {
			$("#menu_ranking").addClass("active");
		});
	</script>
@endsection