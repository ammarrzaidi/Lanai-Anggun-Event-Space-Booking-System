function viewUser(){  
    $.ajax({
        url:"./adminView/viewUser.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}
function viewCatalog(){  
    $.ajax({
        url:"./adminView/viewCatalog.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

function viewMessage(){  
    $.ajax({
        url:"./adminView/viewMessage.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

function viewHallLayout(){  
    $.ajax({
        url:"./adminView/viewHallLayout.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}