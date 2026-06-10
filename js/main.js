
function checkIfOpen() {

    $.ajax({
        url:    "openingHours.php",
        method: "POST",
        dataType: "json",
        data: {
                action: "isOpen",
        },
        success: function(data) {

            if (data.status === 'true') {

                // Highlight Day
                let times = document.querySelectorAll('.times');
                times.forEach(function(time) {
                    // Loop - add and remove classes as required
                    var tid = time.id;
                    if (tid == data.day) {
                       document.getElementById(tid).classList.add("highlight"); 
                    } else {
                        document.getElementById(tid).classList.remove("highlight"); 
                    }
                });

                document.getElementById('openStatus').innerHTML =  " <span class='status open'>The shop is open.</span>";
            } else {
                var nextOpen = data.nextOpen;
                document.getElementById('openStatus').innerHTML =  " <span class='status closed'>The shop is currently closed, and will reopen " + nextOpen + "</span>";
            }
        }});
};

function getCurrentTime() {

    const d     = new Date();
    let hours   = d.getHours();
    let mins    = d.getMinutes();
    let secs    = d.getSeconds();
    let day     = d.getDay();

    // Format displayed time
    if (hours < 10) {
        hours = '0' + hours;
    }
    if (mins < 10) {
        mins = '0' + mins;
    }
    if (secs < 10) {
        secs = '0' + secs;
    }

    // Show time
    document.getElementById("current-time").innerHTML = "<span class='time-title'>Time: </span><span class='time-el'>" + hours + ":" + mins + "</span>";

    checkIfOpen();

    setTimeout(() => {
        getCurrentTime()
    }, 1000);
}

getCurrentTime();