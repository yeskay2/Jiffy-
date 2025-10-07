function updateReaction(commentId, reactionType, employeeId) {
    $.ajax({
        type: "POST",
        url: "fetch_comments.php",
        data: {
            commentId: commentId,
            reactionType: reactionType,
            employeeId: employeeId
        },
        success: function(response) {
            console.log("Reaction updated:", response);
            flyAnimation();
        },
        error: function(xhr, status, error) {
            console.error("AJAX request error:", error);
        }
    });
}

$(document).ready(function() {   
    var employeeId =user_id;
    function fetchComments() {
        $.ajax({
            type: "GET",
            url: "fetch_comments.php",
            dataType: "json",
            success: function(response) {
                displayComments(response);
            },
            error: function(xhr, status, error) {
                console.error("AJAX request error:", error);
            }
        });
    }

function displayComments(comments) {
    $('#commentsContainer').empty();
    $.each(comments, function(index, comment) {
        var commentHTML = '<div class="comment">' +
            '<div class="comment-author-ava"><img id="community-img" src="./../uploads/employee/' + comment.avatar + '" alt="Avatar"></div>' +
            '<div class="comment-body">' +
            '<p class="comment-text">' + comment.text + '</p>' +
            '<div class="comment-footer">';

        var employeeIdsArray = comment.employeeid.split(',').map(function(item) {
            return item.trim();
        });

        if (employeeIdsArray.includes(employeeId.toString())) {
            commentHTML += '<button class="btn-like" id="colour"><i class="fas fa-grin-beam like-icon"></i>' + comment.likes + '</button>';
        } else {
            commentHTML += '<button class="btn-like" id="colour1" onclick="updateReaction(' + comment.id + ', \'like\', ' + employeeId + ')"><i class="far fa-grin-beam like-icon"></i>' + comment.likes + '</button>';
        }

        if (comment.profile_like && comment.profile_like.length > 0) {
            commentHTML += '<div class="liked-profiles">' +
                '<div class="d-flex align-items-center justify-content-between pt-3 border-top">' +
                '<div class="iq-media-group">';
            $.each(comment.profile_like, function(profileIndex, profile) {
                commentHTML += '<a href="#" class="iq-media">' +
                    '<img class="img-fluid avatar-40 rounded-circle" src="./../uploads/employee/' + profile + '" alt="Liked Profile">' +
                    '</a>';
            });
            commentHTML += '</div>' +
                '</div>' +
                '</div>';
        }

        commentHTML += '<span class="comment-meta mr-2">' + comment.author + '</span>' +
            '<span class="badge badge-primary">' + comment.date + '</span>' +
            '</div>' +
            '</div>' +
            '</div>';
        $('#commentsContainer').append(commentHTML);
    });
}

    fetchComments();

    setInterval(function() {
        fetchComments();
    }, 100);

    $('#refreshCommentsBtn').click(function() {
        fetchComments();
    });
});

function postCommunity(){
    var community = document.getElementById('community');
    community.classList.remove('d-none');
}

function toggleSubjectField() {
    var subject = document.getElementById('subjectField');
    var messageType = document.getElementById('messageType').value;
    var selectMemberField = document.getElementsByName("email[]")[0];

    if (messageType === 'ticket') {
        subject.style.display = 'block';
        selectMemberField.setAttribute("required", "required");
    } else {
        subject.style.display = 'none';
        selectMemberField.removeAttribute("required");
    }
}
