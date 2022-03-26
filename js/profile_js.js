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
function edit_article(artid){
    $('#edit_submit').click(function(){
        var userid = $('#edit_userid').val();
        var edit_title = $('#edit_title').val();
        var edit_text = $('#edit_text').val();
        console.log(userid, edit_title, edit_text);
        $.ajax({
            url:"post_article.php",
            type:"POST",
            data:{
                edit_title : edit_title,
                edit_text : edit_text,
                artid : artid,
                action: "edit"
            },
            dataType:"json",
            success: function(data){
                console.log(data);
                if(data.newtitle){
                    $('#title_'+artid).html(data.newtitle);
                }
                if(data.newtext){
                    $('#text_'+artid).html(data.newtext);
                }
                $('#edit_title').val("");
                $('#edit_text').val("");
            }
        })
    })
} 
function remove_article(artid){
        $.ajax({
            url:"post_article.php",
            type:"POST",
            data:{
                artid : artid,
                action: "delete"
            },
            dataType:"json",
            success: function(data){
                console.log(data);
                $('#container_'+ artid).remove();
            }
        })
}
$(document).ready(function(){
    $('#submit').click(function(){
            //console.log($('#current_user').val());
            $.ajax({
                url:"post_article.php",
                type:"POST",
                data: {
                    title: $('#title').val(),
                    userid: $('#userid').val(),
                    text: $('#text').val(),
                    current_user: $('#current_user').val(),
                    action: "post"
                },
                dataType:"json",
                success: function(data){
                        console.log(data);
                        $("#post_area").append('<div class="container" id="container_'+data.artid+
                        '"><div class="container"><div class="row justify content around"><div class="col 8-offset"><h5 id="title_'+data.artid+'">'+data.title+
                        '</h5></div><button class="btn far fa-edit btn-post" id="edit_'+data.artid+
                        '" data-toggle="modal" data-target=".edit-modal-lg"style="background-color: white;" onClick=edit_article('+data.artid+
                        ')></button><button class="btn far fa-trash-alt" id="delete_'+data.artid+'" style="background-color: white;" onClick=remove_article('+data.artid+
                        ')></button></div></div></br><p style="font-size:14px; margin-left:20px;">'+data.time+'</p><hr><p id="text_'+data.artid+
                        '"style="font-size:17px; margin-left:20px;">'+data.text+'</p><hr><div class="row"><div class="col 8-offset"><button id="like_'+data.artid+
                        '" class="btn btn-outline-info" onClick=add_like("'+data.artid+'","like","'+data.current_user+'") style="margin-left:20px;"><i class="far fa-thumbs-up"></i> Like</button></div><span id="likenum_'+data.artid+
                        '">0</span> - likes <span> <span id="commentnum_'+data.artid+'" style="margin-left:10px;">0</span> - comments <span> </div> <div class="container bg-light"></br><div class="comment"><input type="text" id="comment_'+data.current_user+
                        '_'+data.artid+'" class="form-control" placeholder="Type a comment"></input><input type="button" class="btn comment_submit" id="comment_submit"  value ="Comment" onClick = comment("'+data.artid+
                        '","'+data.current_user+'") style="color:#7EB1B1; margin-top:10px;"></input></div><hr><div id = "'+data.artid+'_comment"></div></div><hr></br></div>');
                        $('#ticket').text('Tickets: '+data.ticket);
                        $('#title').val("");
                        $('#text').val("");
                }

            })
        //event.preventDefault();
    })
    
    //edit profile image menu
	$('#action_menu_btn').click(function(){
	    $('.action_menu').toggle();
    })
    //click edit profile image button
    $('#edit_picture').click(function(){
        $('#imageModal').modal('show');
        $('#image_form')[0].reset();
        $('.')
    })
})

function rotate(userid){
    var  deg = Math.floor(Math.random()*(360+1))+0;
    //console.log(parseInt($('#ticket').text().substr(9),10));
    var ticket = parseInt($('#ticket').text().substr(9));
    if(ticket == 0){
        Swal.fire({
            icon: "info",
            title: "There is no tickets!",
            text: "You should post articles to get tickets.",
            showConfirmButton: true,
            }); 
    }
    else{
        $('#startbtn').animate({
            transform: 8*360 + deg,
        }, {
            step: function(now) {
                $(this).css({
                    '-webkit-transform': 'rotate(' + now + 'deg)',
                    '-moz-transform': 'rotate(' + now + 'deg)',
                    'transform': 'rotate(' + now + 'deg)',
                });
            },
            duration: 3000,
            complete: function(){
                var prize
                if((deg>=0 && deg<18) || (deg>=342 && deg<360)) prize = 0;
                else if(deg>=18 && deg<54) prize = 50;
                else if(deg>=54 && deg<90) prize = 0;
                else if(deg>=90 && deg<126) prize = 150;
                else if(deg>=126 && deg<162) prize = 500;
                else if(deg>=162 && deg<198) prize = 0;
                else if(deg>=198 && deg<234) prize = 20;
                else if(deg>=234 && deg<270) prize = 0;
                else if(deg>=270 && deg<306) prize = 50;
                else if(deg>=306 && deg<342) prize = 20;
                Swal.fire({
                    imageUrl: "../image/gift.jpg",
                    title: "Congraduation",
                    text: "You got $"+prize+" !",
                    showConfirmButton: true,
                    });
                if(ticket > 0 ) getPrize(userid,prize);
            }
        });
    }
}

function getPrize(userid,prize){
    console.log(userid, prize);
            $.ajax({
                url:"post_article.php",
                type:"POST",
                data: {
                    userid: userid,
                    prize: prize,
                    action: "getPrize"
                },
                dataType:"json",
                success: function(data){
                    console.log(data);
                    $('#ticket').text('Tickets: '+data.ticket);
                    $('#account').text('Accounts: '+data.account);
                }
            })
}
