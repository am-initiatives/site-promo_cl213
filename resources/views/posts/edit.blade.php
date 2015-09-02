<div id="edit_post_{{ $post->id }}" class="edit_post">

{!! Form::textarea('body', $post->body, ['rows'=>'5', 'style'=>'margin-bottom: 5px;', 'id'=>'edittext']); !!}

<input type="submit" class="send_edit button tiny" post_id="{{ $post->id }}" value="Enregistrer" style="margin-bottom: 3px;">

<button class="cancel_edit buton tiny secondary" post_id="{{ $post->id }}" style="margin-bottom: 3px;">Annuler</button>

<script type="text/javascript">
$(".send_edit").click(function () {
	id = $(this).attr("post_id");
	sendEdit(id);
});

$(".cancel_edit").click(function () {
	id = $(this).attr("post_id");
	cancelEdit(id);
});
</script>
</div>
