<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Article Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property int $like_count
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ArticleComment[] $article_comments
 * @property \App\Model\Entity\ArticleLike[] $article_likes
 */
class Article extends Entity {
    
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'title' => true,
        'content' => true,
        'article_images' => true,
        'link' => true,
        'link_host' => true,
        'link_title' => true,
        'link_image' => true,
        'link_description' => true,
        'like_count' => true,
        'comment_count' => true,
        'comment_count'=>true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'article_comments' => true,
        'article_likes' => true
    ];
    
}
