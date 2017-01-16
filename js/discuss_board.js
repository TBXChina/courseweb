function Switch_DiscussBoard_Display() {
    var DS = document.getElementById("control_discuss_board_display");
    var title = document.getElementById("discuss_board_title");
    if ( "none" == DS.style.display ) {
        DS.style.display = "block";
        title.innerHTML = "- Discuss Board";
    } else {
        DS.style.display = "none";
        title.innerHTML = "+ Discuss Board";
    }
}
