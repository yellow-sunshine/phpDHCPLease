<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8" />
        <title>ISC-DHCP Lease List</title>
        <link rel="stylesheet" type="text/css" href="/style.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bulma.min.css">

        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bulma.min.css">

        <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.4/css/select.bulma.min.css">

        <link rel="stylesheet" href="https://editor.datatables.net/extensions/Editor/css/editor.bulma.min.css">
</head>

<body>
        <div id="wrap" class="cf">
                <div id="logo"></div>
                <div class="user_input">
                        <p id="user_input" class="user_input__value" style='display:none'></p>
                </div>
                <h2><?php print $subdomain; ?></h2>
                <div id="galleryTab" class="cf">
                        <table class="table text-nowrap is-striped" id='example'>
                                <thead>
                                        <tr>
                                                <th>IP Address</th>
                                                <th>Start</th>
                                                <th>End</th>
                                                <th>Last Seen</th>
                                                <th>Status</th>
                                                <th>MAC</th>
                                        </tr>
                                </thead>
                        </table>
                </div>
        </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bulma.min.js"></script>
        <script>
                function formatAMPM(date) {
                        var hours = date.getHours()
                        var minutes = date.getMinutes()
                        var ampm = hours >= 12 ? 'pm' : 'am'
                        hours = hours % 12
                        hours = hours || 12 // the hour '0' should be '12'
                        minutes = minutes < 10 ? '0' + minutes : minutes
                        var strTime = hours + ':' + minutes + ' ' + ampm
                        return strTime
                }

                function formatDate(DateObj, yr = 0, time = 1, debug = 0) {
                        DateObj.toString()
                        day = DateObj.getDate() + nth(DateObj.getDate())
                        hour = (DateObj.getHours() < 10 ? '0' : '') + DateObj.getHours()
                        hr_min = formatAMPM(DateObj)
                        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                        formatted = monthNames[DateObj.getMonth()] + ' ' + day
                        if (yr) {
                                formatted += ', ' + DateObj.getFullYear()
                        }
                        if (time) {
                                formatted += ' ' + hr_min
                        }
                        return formatted
                }

                function nth(d) {
                        if (d > 3 && d < 21) return 'th'
                        switch (d % 10) {
                                case 1:
                                        return 'st'
                                case 2:
                                        return 'nd'
                                case 3:
                                        return 'rd'
                                default:
                                        return 'th'
                        }
                }

                $(document).ready(function() {
                        $('#example').DataTable({
                                responsive: true,
                                paging: true,
                                language: {
                                        emptyTable: "You have no unfilled LOCK orders at this time."
                                },
                                fixedHeader: false,
                                bLengthChange: false,
                                bAutoWidth: false,
                                info: false,
                                ajax: {
                                        url: "leases.php",
                                        dataSrc: "data.leases"
                                },
                                columns: [{
                                        "data": 'ip', // The date the position was matched
                                        "render": function(data) {
                                                var ip = data
                                                return ip
                                        }
                                }, {
                                        "data": 'starts', // The date the position was matched
                                        "render": function(data) {
                                                var starts = new Date(data + ' UTC')
                                                return formatDate(starts, 0, 1, 0)
                                        }
                                }, {
                                        "data": 'ends', // The date the position was matched
                                        "render": function(data) {
                                                var ends = new Date(data + ' UTC')
                                                return formatDate(ends, 0, 1, 0)
                                        }
                                }, {
                                        "data": 'cltt', // The date the position was matched
                                        "render": function(data) {
                                                var cltt = new Date(data + ' UTC')
                                                return formatDate(cltt, 0, 1, 0)
                                                //return data
                                        }
                                }, {
                                        "data": 'bindingState', // The date the position was matched
                                        "render": function(data) {
                                                var bindingState = data
                                                return bindingState
                                        }
                                }, {
                                        "data": 'hardwareethernet', // The date the position was matched
                                        "render": function(data) {
                                                var hardwareethernet = data
                                                return hardwareethernet
                                        }
                                }]
                        });
                });
        </script>
</body>

</html>