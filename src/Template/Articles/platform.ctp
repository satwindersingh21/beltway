<?php $this->assign('title', __('Platform')); ?>
<?php
echo $this->Html->css(['uploadfile']);
echo $this->Html->script(['jquery.uploadfile']);
?>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"/>
<style>
    .article-no-image {
        display: none !important;
    }
    
    .article-one-image {
        width: 90%;
        float: left;
        height: auto;
        margin: 1%;
        padding: 1%;
    }
    
    .article-multiple-images {
        width: 45%;
        height: auto;
        margin: 1%;
        padding: 1%;
        max-width: 270px;
        max-height: 156px;
        float: left;
    }
</style>
<div class="col-md-2">
    <!--
    <?php if ($showBtn) { ?>
        <div class="create-poll"><a href="<?= $this->Url->build(['controller' => 'Polls', 'action' => 'create']); ?>">Create
                Poll</a></div>
    <?php } else { ?>
        <div class="create-poll"><a href="javascript:void(0);" class="upgrade_account">Create Poll</a></div>
    <?php } ?>
    -->
    &nbsp;
</div>
<div class="col-md-8">
    <div class="platform">
        <div class="agenda">
            <div class="row">
                <div class="col-lg-5">
                    <h3><?= ucfirst(strtolower($authUser['first_name'])) ?> <?= ucfirst(strtolower($authUser['last_name'])) ?></h3>
                </div>
                
                <div class="col-lg-7">
                    <?php /* if ($authUser) { ?>
                        <a href="<?= $this->Url->build(['controller' => 'Chats', 'action' => 'createGroup']); ?>">
                            <button>Upload Agenda</button>
                        </a>
                    <?php } */ ?>
                    <h6 class="pull-right text-right btn btn-info" style="margin-top: 0px;" id="sharePostBtn"><b>Share
                            an article, photo, policy viewpoint</b></h6>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <div class="row" id="contentFormBox" style="display: none;">
            <div class="col-lg-12">
                <form action="javascript:void(0);" id="agendaFormOnPage" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="articleIdOnPage" value="0"/>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="text" name="title" class="form-control" placeholder="Title your topic"
                                   id="agendaSubjectOnPage" style="margin-bottom: 10px;">
                            <label for="agendaSubjectOnPage" class="error"
                                   style="margin-bottom:10px; display: none;"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <textarea type="text" name="content" class="form-control"
                                      placeholder="Share an article, photo, policy viewpoint"
                                      id="agendaContentOnPage" style="height:200px; margin-bottom:10px;"></textarea>
                            <label for="agendaContentOnPage" class="error"
                                   style="margin-bottom:10px; display: none;"></label>
                        </div>
                    </div>
                    <div class="row">
                        
                        
                        <div class="col-lg-6 text-right" style="color: #337ab7">
                            <p id="allowedFiles" class="blink">Only JPG, JPEG AND PNG are supported</p>
                            <p id="fileLimit" class="blink1" style="display:none;">You can upload maximum 10 images.</p>
                        </div>
                        <div class="col-lg-6">
                            <input type="submit" class="btn btn-success pull-right text-bold" style="font-weight: bold;"
                                   value="Publish"
                                   id="publishAgendaBtnOnPage"/>
                            
                            <div style="height:0px;overflow:hidden">
                                <input type="file" id="fileInput" name="atricle_image"/>
                            </div>
                            <button type="button" onclick="chooseFile();" class="btn btn-primary pull-right"
                                    style="margin-right:20px; font-weight: bold;"><i
                                    class="fa fa-image"></i> Photo
                            </button>
                            
                            <script>
                                function chooseFile() {
                                    document.getElementById("ajax-upload-id").click();
                                }
                            </script>
                            <br/>
                            <label class="pull-right" id="photoError" style="display: none; margin-top: 10px; ont-weight: normal; color: #F20034; line-height: 0px;
    font-size: 12px; font-family: " Open Sans", sans-serif;">Only formats are allowed : jpeg, jpg, png, gif.</label>
                        
                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1">&nbsp;</div>
                        <div class="col-lg-10 text-right" style="color: #337ab7">
                            <div id="multipleFileUploader" style="display: none"></div>
                            
                            <div class="ajax-file-upload-container" id="ajaxContainer"></div>
                            <input type="hidden" name="article_images" id="articleImages" value=""/>
                        </div>
                        <div class="col-lg-1">&nbsp;</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="urlPreview">
                                <div class="row">
                                    <div class="col-lg-4" id="previewImage">
                                        <img src="" style="width: 100%; float: left;"/>
                                        <input type="hidden" name="link_image" class="link-fields" id="linkImage"
                                               style="margin-top: 10px;"/>
                                    </div>
                                    <div class="col-lg-8" id="previewDetails">
                                        <input type="hidden" name="link" class="link-fields" id="link"/>
                                        <input type="hidden" name="link_host" class="link-fields" id="linkHost"/>
                                        <input type="hidden" name="link_title" class="link-fields" id="linkTitle"/>
                                        <input type="hidden" name="link_description" class="link-fields"
                                               id="linkDescription"/>
                                        <h5 id="siteBaseUrl"></h5>
                                        <h4 id="siteTitle"></h4>
                                        <p id="siteDescription"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="clear"></div>
        <hr id="contentFormBoxHr" style="display: none">
        <div id="atricles"></div>
    
    </div>
</div>
<!-- div class="col-md-2">
    <div class="exit-poll">
        <?php if ($showBtn) { ?>
            <a href="<?= $this->Url->build(['controller' => 'Polls', 'action' => 'exitPolling']); ?>"><img
                    src="/beltway/img/exit-poll.jpg" alt=""></a>
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
</div -->

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
                        <span class="remove_article" id="removeArticle_${id}" title="Remove Agenda">
                            <i class="fa fa-remove"></i>
                        </span>
                        {%/if%}
                    <?php } ?>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-lg-12 text-left">
                    {%if article_images == null || article_images.length == 0 %}
                    &nbsp;
                    {%else%}
                    {{each(index, val) images = article_images.split(',')}}
                    <div class=" {%if images.length == 1 %} article-one-image {%else%} article-multiple-images {%/if%}">
                        <a data-toggle="lightbox" rel="gp_${id}" href="<?= SITE_URL ?>${val}">
                            <img src="<?= SITE_URL ?>${val}" style="width: 100%; height: 100%; object-fit: contain;"/>
                        </a>
                    </div>
                    {{/each}}
                    {%/if%}
                </div>
            </div>
            
            <p id="articleContentBox_${id}">{{html content}}</p>
            
            <div
                style="display: {%if link.length %}block{%else%}none{%/if%}; border: 1px solid #ababab; margin: 3% 0% 0 3%; float:left; width: 96%;">
                <a href="${link}" target="_blank">
                    <div class="row">
                        <div class="col-lg-4">
                            <img src="${link_image}" style="width: 100%; float: left; margin: 10%"/>
                        </div>
                        <div class="col-lg-8">
                            <h5 style="margin-left: 5%;">${link_host}</h5>
                            <h4>${link_title}</h4>
                            <p style="width: 95%;">${link_description}</p>
                        </div>
                    </div>
                </a>
            </div>
            
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

<template id="imageTmpl">
    <div class="ajax-file-upload-statusbar" style="width: 100%;" id="oldImage_${index}">
        <img class="ajax-file-upload-preview" src="<?= SITE_URL; ?>${img}" style="width: 10%; height: auto;">
        <div class="ajax-file-upload-red delete-old-img" style="" data-img="${img}">Delete</div>
    </div>
</template>


<?= $this->element('post-article') ?>
<?= $this->element('upgrade-account') ?>
<?= $this->element('coming_soon') ?>
<?= $this->element('create-poll') ?>
<script type="text/javascript">
    var loadPage = 1;
    var loadingData = false;
    var photoTypeError = false;
    $(function () {
       
       $("#fileInput").change(function () {
            var file = document.getElementById('fileInput');
            $('#selectedFile').html("<b>Selected File: </b>" + file.files.item(0).name);
            var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                $('#photoError').fadeIn();
                photoTypeError = true;
            } else {
                $('#photoError').fadeOut();
                photoTypeError = false;
            }
        });
        
       
        
        
        $("#agendaFormOnPage").validate({
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
                
                var formData = new FormData();
                formData.append('id', $('#articleIdOnPage').val());
                formData.append('title', $('#agendaSubjectOnPage').val());
                formData.append('content', $('#agendaContentOnPage').val());
                formData.append('link', $('#link').val());
                formData.append('link_host', $('#linkHost').val());
                formData.append('link_title', $('#linkTitle').val());
                formData.append('link_description', $('#linkDescription').val());
                formData.append('link_image', $('#linkImage').val());
                formData.append('article_images', $('#articleImages').val());
                
                if (!photoTypeError) {
                    $.ajax({
                        url: SITE_URL + "/articles/add-api",
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.code == 200) {
                                $('#previewImage img').attr('src', '');
                                $('#siteBaseUrl, #siteTitle, #siteDescription, #selectedFile, #ajaxContainer').html('');
                                $('#agendaSubjectOnPage, #agendaContentOnPage, .link-fields').val('');
                                document.getElementById("agendaFormOnPage").reset();
                                $.template("articleTmpl", $('#articleTmpl').html());
                                $.tmpl("articleTmpl", [response.data.article]).prependTo("#atricles");
                            } else {
                                $().showFlashMessage("error", response.message);
                                
                            }
                        }
                    });
                    return false;
                }
            }
            
        });
        
       function getArticles() {
            loadingData = true;
            $.ajax({
                url: SITE_URL + "/articles/get-articles-api/" + loadPage,
                type: "POST",
                data: {key: $('#searchKey').val()},
                dataType: "json",
                success: function (response) {
                    
                    if (response.code == 200) {
                        loadPage = parseInt(loadPage) + 1;
                        $.template("articleTmpl", $('#articleTmpl').html());
                        $.tmpl("articleTmpl", response.data.articles).appendTo("#atricles");
                        loadingData = false;
                    } else {
                        if (loadPage > 1) {
                            $("#atricles").append('<div class="clear"></div><h3 class="no-more-records">No more records found</h3>');
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
        
        $('#postArticle').on('click', '.delete-old-img', function () {
            var images = $('#articleImagesPopup').val().split(',');
            var imgs = [];
            var currentImage = $(this).attr('data-img');
            $.each(images, function (index, img) {
                if (currentImage != img) {
                    imgs.push(img);
                }
            });
            
            $('#articleImagesPopup').val(imgs.join(","));
            $(this).parent().remove();
        });
        
        
        $('#uploadAgenda').click(function () {
            $('#agendaSubject').val('');
            $('#agendaContent').val('');
            $('#articleId').val(0);
            $('#publishAgendaBtn').val('Update');
            $('#postArticle').modal('show');
        });
        
        
       $('#atricles').on('click', '.post_comment', function () {
            
            var articleId = $(this).attr('id').split('_')[1];
            var comment = $('#atricleCommentBox_' + articleId).val();
            var commentId = $('#commentId_' + articleId).val();
            
            $.ajax({
                url: SITE_URL + "/article-comments/save-api/",
                type: "POST",
                data: {article_id: articleId, comment: comment, id: commentId},
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
        
        
        var progress = null;
        $('#agendaContentOnPage').keyup(function () {
            var q = $(this).val();
            progress = $.ajax({
                type: 'POST',
                data: 'q=' + q,
                url: SITE_URL + "/articles/url-exists/",
                dataType: "JSON",
                beforeSend: function () {
                    //checking progress status and aborting pending request if any
                    if (progress != null) {
                        progress.abort();
                    }
                },
                success: function (response) {
                    if (response.code == 200) {
                        
                        $.ajax({
                            type: 'POST',
                            data: 'url=' + response.data.link,
                            dataType: "JSON",
                            url: SITE_URL + "/articles/fetch-preview/",
                            beforeSend: function () {
                                $('#siteBaseUrl').html('Fetching Preview...');
                                $('#previewImage img').attr('src', '');
                                $('#siteTitle, #siteDescription').html('');
                            },
                            success: function (resp) {
                                if (resp.code == 200) {
                                    if (typeof  resp.data.alternate_image != undefined) {
                                        $('#previewImage img').attr('src', resp.data.alternate_image);
                                    }
                                    
                                    if (typeof  resp.data.image != undefined) {
                                        $('#previewImage img').attr('src', resp.data.image);
                                    }
                                    $('#siteBaseUrl').html(resp.data.host);
                                    $('#siteTitle').html(resp.data.title);
                                    $('#siteDescription').html(resp.data.description);
                                    
                                    //
                                    $('#link').val(resp.data.url);
                                    $('#linkHost').val(resp.data.host);
                                    $('#linkTitle').val(resp.data.title);
                                    $('#linkDescription').val(resp.data.description);
                                    $('#linkImage').val(resp.data.image);
                                }
                            }
                        });
                        
                    } else {
                        //Do Somethig
                    }
                },
                complete: function () {
                    // after ajax xomplets progress set to null
                    progress = null;
                }
            });
        });
        
        var xhr = null;
        $('#searchKey').keyup(function () {
            loadPage = 1;
            if (xhr != null) {
                xhr.abort();
            }
            xhr = $.ajax({
                url: SITE_URL + "/articles/get-articles-api/" + loadPage,
                type: "POST",
                data: {key: $(this).val()},
                dataType: "json",
                beforeSend: function () {
                    loadPage = 1;
                    $("#atricles").html('');
                },
                success: function (response) {
                    if (response.data.articles.length) {
                        loadPage = parseInt(loadPage) + 1;
                        $.template("articleTmpl", $('#articleTmpl').html());
                        $.tmpl("articleTmpl", response.data.articles).appendTo("#atricles");
                    } else {
                        $("#atricles").html('<div class="clear"></div><h3 class="no-more-records">No record found</h3>');
                    }
                    
                    xhr = null;
                },
                error: function (jqXHR, exception) {
                    console.log('Something went wrong, check it');
                }
                
            });
            
        });
        
        $('#sharePostBtn').click(function () {
            $('#contentFormBox, #contentFormBoxHr').fadeToggle();
        });
        
        
        <?php if(!empty($authUser['welcome_token'])){ ?>
        setTimeout(function () {
            $.get(SITE_URL + "/users/send-welcome-email");
        }, 2000);
        <?php } ?>
        
        var settings = {
            url: SITE_URL + "/articles/upload",
            method: "POST",
            allowedTypes: "jpg,jpeg,png",
            fileName: "file",
            multiple: true,
            showQueueDiv: 'ajaxContainer',
            showError: false,
            dragdropWidth: '100%',
            statusBarWidth: '100%',
            showFileCounter: false,
            maxFileCount: 10,
            showDelete: true,
            onSuccess: function (files, data, xhr, pd) {
                //
                var d = JSON.parse(data);
                
                if (d.code == 400) {
                    pd.progressbar.removeClass('ajax-file-upload-bar').addClass('ajax-file-upload-red').html("Failed");
                }
                
                if (d.code == 200) {
                    var images = [];
                    if ($('#articleImages').val().length > 0) {
                        images = $('#articleImages').val().split(',');
                    }
                    images.push(d.data.path);
                    $('#articleImages').val(images.join(","));
                }
            },
            onSelect: function (files) {
                if (files.length > 10) {
                    //Blink 5 Times
                    blinkLimit();
                    blinkLimit();
                    blinkLimit();
                    blinkLimit();
                    blinkLimit();
                    return false;
                } else {
                    $('#fileLimit').hide();
                }
                
            },
            onError: function (files, status, errMsg) {
                $("#finalStatus").html("<font color='red'>Upload is Failed</font>");
            },
            deleteCallback: function (data, pd) {
                var d = JSON.parse(data);
                if (d.code == 200) {
                    var images = $('#articleImages').val().split(',');
                    var finalImages = [];
                    $.each(images, function (i, img) {
                        if (d.data.path != img) {
                            finalImages.push(img);
                        }
                    });
                    $('#articleImages').val(finalImages.join(","));
                }
            },
        }
        $("#multipleFileUploader").uploadFile(settings);
        
        function blinkLimit() {
            $('.blink1').fadeOut(500);
            $('.blink1').fadeIn(500);
            $('#fileLimit').css('color', "#ea4d4d").css('font-weight', "bold");
        }
        
        
        $('#atricles').on('click', '.remove_article', function () {
            if (confirm("Are you sure you want to remove this agenda?")) {
                var id = $(this).attr('id').split('_')[1];
                
                $.ajax({
                    url: SITE_URL + "/articles/remove-article-api/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        $('#article_' + id).fadeOut();
                        $('#article_' + id).remove();
                    }
                });
            }
        });
        
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
        
        
        
        
        
        
        
    });


</script>

<?php /* ALTER TABLE  `articles` CHANGE  `article_image`  `article_images` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ; */ ?>
