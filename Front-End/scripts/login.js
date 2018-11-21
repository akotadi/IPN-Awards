var instance = M.Tabs.init(document.getElementById("tabs-login"), { swipeable: true });
instance.select("swipe-login");

$("a").click(function (event) {
    event.preventDefault();
    //print(document);
    $.post("prueba.php",
        {
            user: "aaa",
            password: "bbbb"
        },
        console.log("Juas ya quedo"));
});