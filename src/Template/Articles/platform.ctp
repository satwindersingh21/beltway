<div class="col-md-2">
    <?php if ($showBtn) { ?>
        <div class="create-poll"><a href="<?= $this->Url->build(['controller' => 'Polls', 'action' => 'create']); ?>">Create Poll</a></div>
    <?php } else { ?>
        <div class="create-poll"><a href="javascript:void(0);" class="upgrade_account">Create Poll</a></div>
    <?php } ?>

</div>
<div class="col-md-8">
    <div class="platform">
        <div class="agenda">
            <div class="row">
                <div class="col-lg-5">
                    <h3><?= ucfirst(strtolower($authUser['first_name'])) ?> <?= ucfirst(strtolower($authUser['last_name'])) ?></h3>
                    <p>Add text and sub title</p>
                </div>
                <?php if ($authUser) { ?>
                    <div class="col-lg-7">
                        <button id="uploadAgenda">Upload Agenda</button>
                    </div>
                <?php } ?>
            </div>
            <div class="clear"></div>
            <hr>
            <div id="atricles"></div>
        </div>
    </div>
</div>
<div class="col-md-2">
    <div class="exit-poll">
        <?php if ($showBtn) { ?>
            <a href="<?= $this->Url->build(['controller' => 'Polls', 'action' => 'exitPolling']); ?>"><img src="/beltway/img/exit-poll.jpg" alt=""></a>
        <?php } else { ?>
            <a href="javascript:void(0)" class="upgrade_account"><img src="/beltway/img/exit-poll.jpg" alt=""></a>
        <?php } ?>
    </div>
    
    <div class="town-hall">
        <?php if (!$showBtn) { ?>
            <a href="<?= $this->Url->build(['controller' => 'Chats', 'action' => 'townHall', '9fdbf231fd4160a129e590b8b71da453']); ?>">
                <img src="/beltway/img/town-hall.jpg" alt=""></a>
        <?php } else { ?>
            <a href="javascript:void(0)" class="upgrade_account"><img src="/beltway/img/town-hall.jpg" alt=""></a>
        <?php } ?>
    </div>
</div>

<template id="articleTmpl">
    <div class="post-section" id="article_${id}">
        <div class="post-user"><img src="<?= PROFILE_IMAGE_PATH ?>thumbnail-${user.profile_image}" alt=""></div>
        <div class="post-content">
            <div class="row">
                <div class="col-lg-10"><h4 id="articleTitleBox_${id}">${title}</h4></div>
                <div class="col-lg-2">
                    <?php if ($showBtn) { ?>
                        {%if user_id == currentUserId %}
                        <span class="edit_article" id="editArticle_${id}" title="Edit Agenda">
                            <i class="fa fa-pencil"></i>
                        </span>
                        {%/if%}
                    <?php } ?>
                </div>
            </div>
            <p id="articleContentBox_${id}">{{html content}}</p>
            
            <div class="comment-section">
                <div class="row">
                    <div class="col-lg-7"><p>
                            <a href="javascript:void(0);" id="likeArticle_${id}" class="like_article"
                               data-like-count="${like_count}">{%if article_likes.length %}Unlike{%else%}Like{%/if%}</a>
                            {%if
                            like_count != 0 %} <em>(${like_count})</em> {%/if%} |
                            <a href="javascript:void(0);" id="showComment_${id}" class="show_comments"
                               data-comment-count="${comment_count}">Add your
                                comment</a> {%if comment_count != 0 %} <em>(${comment_count})</em> {%/if%}</p></div>
                    <div class="col-lg-5"><p><span>${created}</span></p></div>
                </div>
                
                <div class="comment-box" id="commentBox_${id}" style="display: none">
                    <textarea placeholder="Write a comment here" name="comment" id="atricleCommentBox_${id}"></textarea>
                    <input type="hidden" name="id" id="commentId_${id}" value="0">
                    <button class="post_comment" id="postComment_${id}">Submit</button>
                </div>
            </div>
            <div id="articleComments__${id}"></div>
        </div>
    </div>
</template>
<template id="commentTmpl">
    <div class="user-comment">
        <h6>${user.first_name} ${user.last_name} &nbsp;&nbsp;&nbsp;&nbsp;</h6>
        <p id="commentP_${id}_${article_id}">${comment}</p>
        {%if user_id == currentUserId %} <span class="edit_comment" id="editComment_${id}_${article_id}"
                                               title="Edit Comment" style="float: right; margin-top: -20px;"><i
                class="fa fa-pencil"></i></span>
        {%/if%}
    </div>
</template>


<?= $this->element('post-article') ?>
<?= $this->element('upgrade-account') ?>
<?= $this->element('coming_soon') ?>
<?= $this->element('create-poll') ?>
<script type="text/javascript">
    var loadPage = 1;
    var loadingData = false;
    $(function () {
        
        $("#agendaForm").validate({
            rules: {
                title: {
                    required: true
                },
                content: {
                    required: true
                }
            },
            messages: {
                title: {
                    required: "Please enter agenda subject"
                },
                content: {
                    required: "Please enter agenda description"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: SITE_URL + "/articles/add-api",
                    type: "POST",
                    data: $("#agendaForm").serialize(),
                    dataType: "json",
                    success: function (response) {
                        var ArticleId = $('#articleId').val();
                        
                        if (response.code == 200) {
                            $('#postArticle').modal('hide');
                            $('articleId').val('0');
                            if (ArticleId == 0) {
                                $.tmpl("articleTmpl", [response.data.article]).prependTo("#atricles");
                            } else {
                                $('#articleTitleBox_' + ArticleId).html(response.data.article.title);
                                $('#articleContentBox_' + ArticleId).html(response.data.article.content);
                            }
                        } else {
                            $().showFlashMessage("error", response.message);
                            
                        }
                    }
                });
                return false;
            }
        });
        
        
        function getArticles() {
            loadingData = true;
            $.ajax({
                url: SITE_URL + "/articles/get-articles-api/" + loadPage,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    
                    if (response.code == 200) {
                        loadPage = parseInt(loadPage) + 1;
                        $.template("articleTmpl", $('#articleTmpl').html());
                        $.tmpl("articleTmpl", response.data.articles).appendTo("#atricles");
                        loadingData = false;
                    } else {
                        if(loadPage > 1){
                         $("#atricles").append('<h3 class="no-more-records">No more records found</h3>');
                        } else {
                            $().showFlashMessage("error", response.message);
                        }
                    }
                    
                    
                }
            });
            
        }
        
        setTimeout(function () {
            getArticles();
        }, 500);
        
        $('#atricles').on('click', '.edit_article', function () {
            var id = $(this).attr('id').split('_')[1];
            
            $.ajax({
                url: SITE_URL + "/articles/get-article-api/" + id,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    
                    if (response.code == 200) {
                        $('#agendaSubject').val(response.data.article.title);
                        $('#agendaContent').val(response.data.article.content);
                        $('#articleId').val(response.data.article.id);
                        $('#publishAgendaBtn').val('Update Agenda');
                        $('#postArticle').modal('show');
                    } else {
                        $().showFlashMessage("error", response.message);
                    }
                }
            });
            
        });
        
        $('#uploadAgenda').click(function () {
            $('#agendaSubject').val('');
            $('#agendaContent').val('');
            $('#articleId').val(0);
            $('#publishAgendaBtn').val('Publish Agenda');
            $('#postArticle').modal('show');
        });
        
        
        $('#atricles').on('click', '.post_comment', function () {
            
            var articleId = $(this).attr('id').split('_')[1];
            var comment = $('#atricleCommentBox_' + articleId).val();
            var commentId = $('#commentId_' + articleId).val();
            
            $.ajax({
                url: SITE_URL + "/article-comments/save-api/",
                type: "POST",
                data: {article_id: articleId, comment, id: commentId},
                dataType: "json",
                success: function (response) {
                    
                    if (response.code == 200) {
                        if (commentId == 0) {
                            $.template("commentTmpl", $('#commentTmpl').html());
                            $.tmpl("commentTmpl", [response.data.articleComment]).appendTo("#articleComments__" + articleId);
                            var commentCount = $('#showComment_' + articleId).attr('data-comment-count');
                            
                            $('#showComment_' + articleId).attr('data-comment-count', (parseInt(commentCount) + 1));
                            if (commentCount == "0") {
                                $('#showComment_' + articleId).after(" <em>(" + (parseInt(commentCount) + 1) + ")</em>");
                            } else {
                                $('#showComment_' + articleId).next('em').html("(" + (parseInt(commentCount) + 1) + ")");
                            }
                        } else {
                            $('#commentP_' + commentId + '_' + articleId).html(response.data.articleComment.comment);
                        }
                        $('#atricleCommentBox_' + articleId).val('');
                        $('#commentId_' + articleId).val(0);
                    } else {
                        $('').showFlashMessage("error", response.message);
                    }
                }
            });
        });
        
        $('.upgrade_account').click(function () {
            $('#upgradeAccount').modal('show');
        });
        
        $('.coming_soon').click(function (e) {
            e.preventDefault();
            $('#comingSoon').modal('show');
        });
        
        $('#createPoll').click(function (e) {
            e.preventDefault();
            $('#comingSoon').modal('show');
        });
        
        $('#atricles').on('click', '.show_comments', function () {
            var articleId = $(this).attr('id').split('_')[1];
            $('#commentBox_' + articleId).fadeIn();
            
            $.ajax({
                url: SITE_URL + "/article-comments/get-comments-api/" + articleId,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    
                    if (response.code == 200) {
                        $.template("commentTmpl", $('#commentTmpl').html());
                        $.tmpl("commentTmpl", response.data.articleComments).appendTo("#articleComments__" + articleId);
                    } else {
                        $('').showFlashMessage("error", response.message);
                    }
                }
            });
        });
        
        $('#atricles').on('click', '.edit_comment', function () {
            
            var commentId = $(this).attr('id').split('_')[1];
            var articleId = $(this).attr('id').split('_')[2];
            $('#commentBox_' + articleId).fadeIn();
            $('#atricleCommentBox_' + articleId).val($('#commentP_' + commentId + '_' + articleId).html());
            $('#commentId_' + articleId).val(commentId);
            window.location.hash = '#showComment_' + articleId;
        });
        
        $('#atricles').on('click', '.like_article', function () {
            
            var articleId = $(this).attr('id').split('_')[1];
            $.ajax({
                url: SITE_URL + "/articles/like-unlike/",
                type: "POST",
                data: {article_id: articleId},
                dataType: "json",
                success: function (response) {
                    
                    if (response.code == 200) {
                        if ($('#likeArticle_' + articleId).next('em').length) {
                            if (response.data.likes_count == 0) {
                                $('#likeArticle_' + articleId).next('em').html('');
                            } else {
                                $('#likeArticle_' + articleId).next('em').html('(' + response.data.likes_count + ')');
                            }
                            
                        } else {
                            $('#likeArticle_' + articleId).after('<em>(' + response.data.likes_count + ')</em>');
                        }
                        
                        if ($('#likeArticle_' + articleId).html() == "Like") {
                            $('#likeArticle_' + articleId).html('Unlike');
                        } else {
                            $('#likeArticle_' + articleId).html('Like');
                        }
                        
                        
                    } else {
                        $().showFlashMessage("error", response.message);
                    }
                }
            });
        });
    
        $(window).scroll(function () {
            if ($(window).scrollTop() == $(document).height() - $(window).height()) {
                if (!loadingData) {
                    getArticles();
                }
            }
        });
        
    });
    
    

</script>