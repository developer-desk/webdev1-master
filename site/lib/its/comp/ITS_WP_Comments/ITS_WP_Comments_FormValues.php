<?php 
class ITS_WP_Comments_FormValues
{
    public $post_id;
    public $post_comment_status;
    public $cancel_comment_reply_link;
    public $option_comment_registration;
    public $option_site_url;
    public $form_action;
    public $form_id;
    public $comment_author;
    public $comment_author_email;
    public $comment_id_fields;
    
    public function __construct()
    {
        global $post, $comment_author, $comment_author_email;
        $this->post_id = isset($post) ? $post->ID : null;
        $this->post_comment_status = isset($post) ? $post->comment_status : null;
        $this->cancel_comment_reply_link = function_exists("cancel_comment_reply_link") ? cancel_comment_reply_link() : null;
        if (function_exists("get_option"))
        {
            $this->option_comment_registration = get_option('comment_registration');
            $this->option_site_url = get_option('siteurl');
            $this->form_action = get_option('siteurl')."/wp-comments-post.php";            
        }        
        $this->form_id = "commentform";
        $this->comment_author = $comment_author;
        $this->comment_author_email = $comment_author_email;
        $this->comment_id_fields = function_exists("cancel_comment_reply_link") ? get_comment_id_fields() : null;  
    }    
}    

$args = (array)(new ITS_WP_Comments_FormValues());
echo $args;


?>
