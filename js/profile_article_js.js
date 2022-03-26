function add_like(artid, action, username){
    var likenum = $('#likenum_'+artid).text();
    console.log(artid,likenum,action,username);
    $.ajax({
        url: "post_article.php",
        type: "POST",
        data:{
            artid: artid,
            username: username,
            action: action
        },
        dataType:"json",
        beforeSend: function(){
            if(username == ""){
                Swal.fire({
                    icon: "warning",
                    title: "You should login first!",
                    showConfirmButton: true,
                    }); 
            }
        },
        success: function(data){
            console.log(data);
            if(action == "like"){
                document.getElementById('like_'+artid).firstChild.className = "fas fa-thumbs-up";
                document.getElementById('like_'+artid).setAttribute('onclick','add_like("'+artid+'", "unlike", "'+username+'")');
                like_num = parseInt(likenum)+1;
                $('#likenum_'+artid).text(like_num.toString());
            }
            else if(action == "unlike"){
                document.getElementById('like_'+artid).firstChild.className = "far fa-thumbs-up";
                document.getElementById('like_'+artid).setAttribute('onclick','add_like("'+artid+'", "like", "'+username+'")');
                like_num = parseInt(likenum)-1;
                $('#likenum_'+artid).text(like_num.toString());
            }
        }
    })
}  
function comment(artid, current_user){
    var comment = $('#comment_'+ current_user +'_'+ artid).val();
    //console.log(comment);
    //console.log(artid,current_user);
        $.ajax({
            url:"post_article.php",
            type: "POST",
            data:{
                comment : comment,
                username: current_user,
                artid: artid,
                action: "Comment"
            },
            dataType:"json",
            success: function(data){
                console.log(data);
                //console.log('#'+artid+'_comment');
                $('#'+artid+'_comment').append('<div class="row justify content around"><div class="col 8-offset"><h5 style="font-size:14px; color:#717D7E; margin-left:20px;" >'+data.name+
                '</h5></div><p style="font-size:14px; color: #717D7E; margin-right:20px;">'+data.time+
                '</p></div><p style="font-size:14px; color: #717D7E; margin-left:20px;">'+data.comment+'</p></br>');
                $('#commentnum_'+artid).html(data.num);
                $('#comment_'+ current_user +'_'+ artid).val("");
            }
        })
}