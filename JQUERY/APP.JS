$(function () {
    /* $("#myspan").fadeOut(3000,function(){
        $(this).fadeIn(3000); 
     });*/
    /* $("p").hide();
        $("#btn").click(function () {
            $("p:hidden").show();
        })
       $("img").each(function(index){
           
       });*/
    /*  $("p").each(function(index){
         $(this).text("paragraphe numero "+(index+1)); 
      });
      $("#img").attr({
          src:'img1.jpg',
          width:'400px',
          height:'400px'
      });
      $("#input-name").next("span");
      $("#").prev("span");
      $("#btn").click(function(){
         $("div").toggleClass('red');
          console.log($("div").hasClass('red'));
      });*/
    // $(":radio").val(['homme']);
    /* $("#btn").click(function(){
         console.log($(':radio[name="sexe"]:checked').val());
     });*/
    /*$('<hr>').insertBefore($("h1"));
    $("#btn").clone().html("ddd ").insertBefore($("#btn"));*/
    /* $("#btn").click(function () {
         var txt = $("#txt").val();
         // $('<li>'+txt+'</li>').appendTo($('ul'));
         if (txt.trim().length != 0) {
             $('ul').append('<li>' + txt + '</li>');
             $("#txt").val("");
         }
     });
     */
    /* $("#btn").click(function () {
         var value = $("#txt").val();
         var li = '<li>' + value + '</li>';
         //$("ul").append(li);
         $(li).appendTo($("ul"));
         $("#txt").val("");
     });*/
    /* $("#btn").click(function(){
         console.log($(':radio[id="femme"]:checked').val());
     });*/
    /*  $("img").first().show(3000,function showNextOne(){
          $(this).next("img").show(3000,showNextOne);
      });*/

    /*$("img").first().fadeOut(5000, function hideNextOne() {
        $(this).next("img").fadeOut(5000, hideNextOne);
    });*/
    /*$("#btn").click(function () {
        $("#message").fadeIn('slow').delay(3000).fadeOut('slow');
    });*/
    var hour = function () {
        var date = new Date();
        var h = date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
        $("#hour").text(h);
    }
    hour();
    setInterval(hour, 1000);
    $("#name").focus(function(){
        $(this).css('border','2px solid red');
    });
    $("#name").blur(function(){
        $(this).css('border','');
    });
})