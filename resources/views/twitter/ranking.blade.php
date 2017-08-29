@extends('layouts.app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-3">
					<h4>#Ranking</h4>
				</div>
				<div class="col-md-8">
					<form class="form-inline" id="history_form" method="GET" action="{{ action('TwitterController@ranking') }}">
						<input type="hidden" id="order" name="order" value="{{ $request->order }}">
						<div class="form-group">
							<input type="text" class="form-control input_date" name="start_date" value="{{ $request->start_date }}" placeholder="Início">
							<input type="text" class="form-control input_date" name="end_date" value="{{ $request->end_date }}" placeholder="Término">
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
						<th>Nº</th>
						<th>Hashtag</th>
						<th>Tweets</th>
						<th>
							Última busca
							&nbsp;
							@if ($request->order == 'ASC')
								<a id="link_order_date" data-order="DESC" href="#">
									<span class="glyphicon glyphicon-menu-up"></span>
								</a>
							@else
								<a id="link_order_date" data-order="ASC" href="#">
									<span class="glyphicon glyphicon-menu-down"></span>
								</a>
							@endif
						</th>
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
								<a class="btn btn-{{ ($position == 0) ? 'default' : 'success' }} btn-sm" href="{{ url('twitter/hashtaghistory/' . $hashtag->hashtag_id)}}">Histórico</a>
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

			$.datepicker.regional["pt-BR"];
      		$(".input_date").datepicker();

      		$("#link_order_date").on('click', function(event) {
      			event.preventDefault();

  				$("#order").val($(this).data('order'));
      			$("#history_form").submit();
      		});
		});
	</script>
@endsection