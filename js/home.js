function showActive(){
    var url = (window.location.href).toString();
    var tag = url.split("#")[1];
    // alert(tag);
    if(tag){
        $(".nav-link").removeClass("active");
        $("#"+tag+'-tab').addClass("active");
        $(".tab-pane").removeClass("show active");
        $("#"+tag).addClass("show active");
    }
}

function showFaculty(){
    var dept = $("#deptFilter").val();
    var year = $("#yearFilter").val();
    var block = $("#blockFilter").val();
    var course = $("#courseFilter").val();
    var type = $("#typeFilter").val();
    $.get("model/getFaculty.php", data={modify: "no", department: dept, year: year, block: block, course: course, type: type}, function(data, status){
        $("#facultyTable").html(data);
    });
}