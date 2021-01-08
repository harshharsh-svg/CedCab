$(function () {
    $("#table").hide();
    $("#sel3").change(function () {
        if ($(this).val() == 1) {
            $("#text3").attr("disabled", "disabled");
            $("#text3").val("");
            $("#text3").attr("placeholder", "Luggage inavailable");
        } else {
            $("#text3").removeAttr("disabled");
            $("#text3").attr("placeholder", "Enter the Luggage Weight");
            $("#text3").focus();
        }
    });
    $('#text3').keyup(function () {
        this.value = this.value.replace(/[^0-9\.]/g, '');
    });
    //ajax function used for cab fare calculation
    $("#btn1").click(function (e) {
        e.preventDefault();
        var a = $("#sel1").val();
        var b = $("#sel2").val();
        var c = $("#sel3").val();
        var d = $("#text3").val();
        if (a == "0" || b == "0" || c == "0") {
            if (a == "0") {
                $("#sel1").focus();
            }
            if (b == "0") {
                $("#sel2").focus();
            }
            if (c == "0") {
                $("#sel3").focus();
            }
            alert("Please Enter values in input field");
            return;
        } else {
            $("#btn1").hide();
            $("#btn2").show();
        }
        if (a == b) {
            alert("Pickup Location and Destination can not be same");
            return;
        }
        console.log(a, b, c, d);
        $.ajax({
            url: "cal_cab_Fare.php",
            type: "POST",
            data: { Location: a, Destination: b, Cab: c, Luggage: d },
            success: function (result) {
                // alert(result);
                $('.booktable').show();
                $('#table1').html(result);
            },
            error: function () {
                alert("error");
            }
        });
    });

    var original = '';
    $('.checkForDot').on('input', function () {
        if ($(this).val().replace(/[^.]/g, "").length > 1) {
            $(this).val(original);
        } else {
            original = $(this).val();
        }
    });

    $("#sel1,#sel2,#sel3,#text3").click(function () {
        $("#btn1").show();
        $("#btn2").hide();
    });
    //hide booktable
    $('.booktable').hide();

    //hide button when any keypress event occur
    $('#sel1,#sel2,#sel3,#text3').keypress(function (e) {
        $('#btn1').show();
        $('#btn2').hide();
    });

    $("#btn2").click(function (e) {
        e.preventDefault();
        var a = $("#sel1").val();
        var b = $("#sel2").val();
        var c = $("#sel3").val();
        var d = $("#text3").val();
        var action = 1;
        if (a == "0" || b == "0" || c == "0") {
            if (a == "0") {
                $("#sel1").focus();
            }
            if (b == "0") {
                $("#sel2").focus();
            }
            if (c == "0") {
                $("#sel3").focus();
            }
            alert("Please Enter values in input field");
            return;
        } else {
            $("#btn2").show();
        }
        if (a == b) {
            alert("Pickup Location and Destination can not be same");
            return;
        }
        console.log(a, b, c, d, action);
        $.ajax({
            url: "cal_cab_Fare.php",
            type: "POST",
            data: { Location: a, Destination: b, Cab: c, Luggage: d, action: action },
            success: function (result) {
                $data = $('#table1').html();
                if ($data == result) {
                    var r = confirm("Do You Want to Continue to Confirm Ride?");
                    if (r == true) {
                        alert("please login");
                        window.location.href = 'Admin/login.php';
                    } else {
                        window.location.href = 'destroy.php';
                    }
                } else {
                    var r = confirm("Do You Want to Continue to Confirm Ride?");
                    if (r == true) {
                        alert("RIDE BOOK PLEASE WAIT FOR APPROVAL");
                        window.location.href = 'user_pending_ride.php';
                    } else {
                        window.location.href = 'destroy.php';
                    }
                }
            },
            error: function () {
                alert("error");
            }
        });
    });
    $('.table2').hide();
    $("#edit").click(function (e) {
        $('.table1').hide();
        $('.table2').show();
        e.preventDefault();
    })
});