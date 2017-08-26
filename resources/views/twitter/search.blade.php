@extends('layouts.app')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<form method="GET" action="search">
				<div class="form-group">
					<div class=" col-md-4 col-md-offset-3">
						<label for="hashtag">#Hashtag#</label>
						<input type="text" name="hashtag" value="{{ $hashtag }}" size="38">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<input type="submit" class="btn btn-primary btn-sm" value="Buscar">
					</div>
				</div>
			</form>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="alert alert-success col-md-2 col-md-offset-5 text-center" role="alert">
				  <h2>{{ $countTweets }}</h2>
				  <h2 class="alert-heading">TWEETS</h4>
				</div>
			</div>

			@foreach ($topTweets as $tweet)
				<div class="row">
					<div class="col-md-1 col-md-offset-2">
						<img src="{{ $tweet->user->profile_image_url }}">
					</div>

					<div class="col-md-9">
						<div>{{ $tweet->user->name }}</div>
						<div>#{{ $tweet->user->screen_name }}</div>
						<div>{{ $tweet->retweeted_status->text }}</div>
						<div>
							@if (isset($tweet->retweeted_status->extended_entities->media))
								@foreach ($tweet->retweeted_status->extended_entities->media as $key => $media)
									@if ($media->type == 'video')
										<video width="480" height="360" controls>
											<source src="{{ $media->video_info->variants[0]->url }}" type="{{ $media->video_info->variants[0]->content_type }}">
											Este navegador não suporta a visualização de vídeos.
										</video>
									@else
										@if ($key == 0)
											<div style="float: left;">
												<img class="img-fluid" src="{{ $media->media_url }}" height="{{ $media->sizes->small->h }}" width="{{ $media->sizes->small->w }}">
											</div>
										@else
											<div style="float: left;">
												<img class="img-fluid" src="{{ $media->media_url }}" height="{{ $media->sizes->thumb->h }}" width="{{ $media->sizes->thumb->w }}">
											</div>
										@endif
									@endif
								@endforeach
							@endif
						</div>						
						<div style="width: 100%; float: left;">{{ $tweet->retweeted_status->retweet_count }}</div>
					</div>
				</div>
				<hr>
			@endforeach
		</div>
	</div>

	<script type="text/javascript">
		$(function() {

		});
	</script>
@endsection