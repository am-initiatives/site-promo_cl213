@if($user->isAllowed('post'))
<div class="panel post">
	@include('posts.form')
</div>
@endif
@foreach($posts as $post)
<div class="panel post">
	<div class="header">
		<div class="picture">
			<a href="{{ $post->user->getLink() }}">
				<img class="small-picture" style='height: 50px;' src="{{ $post->user->getPictureLink() }}">
			</a>
		</div>
		<div class="info">
			{!! $post->user->getLinkTitle() !!}
			<br/>
			<span style="color: #777">{{ Html::diff($post->created_at) }}</span>
		</div>
		@if($user->isAllowed('edit_posts', $post->user_id))
		<div class="right text-right">
			@if($user->isAllowed(null, $post->user_id))
			<a href="#" class="edit_button" post_id="{{ $post->id }}">Editer</a>
			<span> - </span>
			@endif
			<a href="javascript:void(0)" class="del_button" post_id="{{ $post->id }}">Supprimer</a>
		</div>
		@endif
	</div>
	<div id="post_{{ $post->id }}">
		{!! $post->showBody() !!}
	</div>
</div>
@endforeach

@section("scripts")
	@parent
	<script type="text/javascript">
	$(document).ready(function () {
		$(".edit_button").click(function () {
			var id = $(this).attr("post_id");
			getEdit(id);
			return false;
		});

		$(".del_button").click(function () {
			var id = $(this).attr("post_id");
			$.ajax({
				method: "DELETE",
				url: "{{ route('posts.destroy', '') }}/"+id,
				context: $(this).closest(".post")
			}).done(function (data) {
				this.html(data);
			});
		});
	});

	function getEdit(id) {
		$.ajax({
			url: "{{ route('posts.edit', '') }}/"+id,
			context: $("#post_"+id)
		}).done(function (data) {
			this.hide(0);
			this.after(data);
			$("#edittext").focus();
			$("#edittext").scrollIntoView();
		});
	}

	function sendEdit(id) {
		$.ajax({
			method: "POST",
			url: "{{ route('posts.update', '') }}/"+id,
			context: $("#post_"+id),
			data: {
				body: $("#edittext").val()
			}
		}).done(function (data) {
			this.html(data);
			this.show(0);
			$(".edit_post").empty();
		});
	}

	function cancelEdit(id) {
		$("#edit_post_"+id).empty();
		$("#post_"+id).show(0);
	}
	</script>
@endsection