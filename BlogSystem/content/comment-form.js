
function showCommentForm(){
    if ($('#showBtn').val() === 'Leave a Reply') {
        $('#comment-form').show();
        $('#showBtn').val('Hide form');
    } else {
        $('#comment-form').hide();
        $('#showBtn').val('Leave a Reply');
    }
};

function hideForm(){
    $('#comment-form').hide();
    $('#showBtn').val('Leave a Reply');
};

