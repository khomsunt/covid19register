$.fn.datepickerSkn = function(today,defaultDate,lock,para_language){
    // alert('para_language-'+para_language+'-');
    var language=null;
    if (typeof para_language !='undefined') {
        if (para_language!='' | para_language!=null) {
            language=para_language;
        }
    }
    var date_input=this;
    var calendar_date=new Date(parseInt(today.substr(0,4)), parseInt(today.substr(5,2))-1, 15);
    var datepicker_skn_token=Math.floor(Math.random() * (99999 - 10000) ) + 10000;
    var default_date=null;
    if (typeof defaultDate!= 'undefined') {
        if (defaultDate!='' & defaultDate!=null) {
            default_date=defaultDate;
        }
    }
    var selectedDate='';

    var dayListTh=['อา','จ','อ','พ','พฤ','ศ','ส'];
    var dayListEn=['Su','M','Tu','W','Th','F','Sa'];
    var dayList=[];
    if (language=='en') {
        dayList=dayListEn;
    }
    else {
        dayList=dayListTh;
    }
    // var offset = date_input.offset();
    // var height = date_input.outerHeight(false);
    var masterWidth = date_input.outerWidth(false);
    // var left = offset.left;
    // var top = offset.top;
    var left = date_input.left;
    var top = date_input.top;
    var divMother=$('<div>');
    divMother.addClass('datepicker_skn_master_div').css({
        'display':'none',
        'padding':'3px',
        'background-color':'white', 
        'border-radius':'5px', 
        'border':'solid 1px #999999', 
        'box-shadow': '0px 4px 10px #cccccc', 
        'position':'absolute', 
        'z-index':'50',
        'width': masterWidth+'px',
        'max-width':'400px',
        'min-width':'330px',
    });
    $('body').append(divMother);
    var tableA=$('<table>');
    tableA.css({'border-spacing': '1px', 'border-collapse': 'separate'});
    var tdWidth=Math.floor(masterWidth/7);

    var trTitle=$('<tr>');
    var tdLeft=$('<td>');
    var tdTitle=$('<td>');
    var tdRight=$('<td>');
    trTitle.append(tdLeft);
    trTitle.append(tdTitle);
    trTitle.append(tdRight);

    var divTdLeft=$('<div>');
    var divTdRight=$('<div>');
    tdLeft.css({'text-align':'center'}).append(divTdLeft);
    tdRight.css({'text-align':'right'}).append(divTdRight);
    divTdLeft.text('<').css({'cursor':'pointer', 'font-weight':'bold', 'border-radius':'3px', 'color':'#71aad6', 'border': 'solid 1px #71aad6'});
    divTdRight.text('>').css({'cursor':'pointer', 'font-weight':'bold', 'border-radius':'3px', 'color':'#71aad6', 'border': 'solid 1px #71aad6'});

    var trHead=$('<tr>');
    dayList.forEach(i => {
        var td=$('<td>');
        td.text(i).css({'color':'grey', 'font-weight':'bold', 'height':'40px', 'width': tdWidth+'px', 'text-align':'center'});
        trHead.append(td);
    });
    divMother.append(tableA);
    tableA.css({'width': '100%' });
    tableA.append(trHead);

    tableA.prepend(trTitle);
    tdLeft.css({'width': tdWidth+'px', 'text-align':'center'});
    tdTitle.attr('colspan',5).css({'height':'40px', 'width': (masterWidth-(tdWidth*5))+'px', 'text-align':'center'});
    tdRight.css({'width': tdWidth+'px', 'text-align':'center'});

    var dates;
    if (default_date!=null) {
        dates=makeDateData(default_date);
        selectDate(fullThaidate(default_date),default_date);
        selectedDate=default_date;
    }
    else {
        dates=makeDateData(today);
    }
    setWeekRows(dates);

    date_input.on('click',function() {
        $('.datepicker_skn_master_div').not($("#datepicker_skn_master_div"+datepicker_skn_token)).css({'display':'none'});
        $('.datepicker_skn').not(date_input).prop('disabled',false);
        date_input.prop('disabled',true);
        openCalendar();
    });

    $(divTdLeft).on('click',function() {
        var prevMonthDate = new Date(calendar_date);
        prevMonthDate.setMonth(prevMonthDate.getMonth()-1); 
        calendar_date=prevMonthDate;
        $('.weekRow'+datepicker_skn_token).remove();
        var d=prevMonthDate.getFullYear().toString()+"-"+addZero(prevMonthDate.getMonth()+1,2)+"-"+addZero(prevMonthDate.getDate(),2);
        var x=makeDateData(d);
        setWeekRows(x);
    });

    $(divTdRight).on('click',function() {
        var nextMonthDate = new Date(calendar_date);
        nextMonthDate.setMonth(nextMonthDate.getMonth()+1); 
        calendar_date=nextMonthDate;
        $('.weekRow'+datepicker_skn_token).remove();
        var d=nextMonthDate.getFullYear().toString()+"-"+addZero(nextMonthDate.getMonth()+1,2)+"-"+addZero(nextMonthDate.getDate(),2);
        var x=makeDateData(d);
        setWeekRows(x);
    });

    function openCalendar() {
        var h = date_input.outerHeight(false);
        var offset = date_input.offset();
        var t=offset.top;
        var l=offset.left;
        divMother.css({
            'position':'absolute', 
            'top': t+h+'px',
            'left': l+'px',
        });
        divMother.fadeIn('fast');
    }

    function closeCalendar() {
        date_input.prop('disabled',false);
        divMother.fadeOut('fast');
    }

    function setWeekRows(dates) {
        if (language=='en') {
            tdTitle.text(dates.monthName+" "+(parseInt(dates.thaiYear)-543).toString());
        }
        else {
            tdTitle.text(dates.monthName+" "+dates.thaiYear);
        }
        
        dates.data.forEach(w => {
            var tr=$('<tr>');
            tr.addClass('weekRow'+datepicker_skn_token);
            w.forEach(i => {
                var td=$('<td>');
                td.addClass('dayCell'+datepicker_skn_token).text(i.day).attr({'date_db':i.date_db, 'full_th':i.full_th}).css({'cursor':'pointer', 'height':'40px', 'width': tdWidth+'px', 'text-align':'center', 'border': 'solid 1px transparent', 'border-radius':'3px'});
                if (i.other_month==true) {
                    td.css({'color':'#c9c9c9'});
                }
                tr.append(td);
            });
            tableA.append(tr);
        });

        $('.dayCell'+datepicker_skn_token).on('click',function() {
            selectDate($(this).attr('full_th'),$(this).attr('date_db'));
        });

        $('.dayCell'+datepicker_skn_token).hover(function(e) { 
            $(this).css("border",e.type === "mouseenter"?"solid 1px #60b2ff":"solid 1px transparent") 
        })

        setActionButton();
        // console.log('lock-'+lock);
        if (typeof lock != 'undefined') {
            if (lock=='lock') {
                date_input.prop('disabled',true);
            }
        }
    }

    function selectDate(show_text_value,date_value) {
        date_input.val(show_text_value);
        date_input.attr('date_value',date_value);
        closeCalendar();
    }

    function setActionButton() {
        var tr=$('<tr>');
        var td=$('<td>');
        var div=$('<div>');
        var btnClear=$('<button>');
        var btnClose=$('<button>');
        tr.append(td);
        div.append(btnClear).append(btnClose);
        td.append(div);
        tr.addClass('weekRow'+datepicker_skn_token);
        td.attr('colspan',7);
        div.css({'display':'flex','justify-content':'space-between'});
        btnClear.attr("tyoe","button").addClass("btn btn-default").css({'width':'100%'});
        btnClose.attr("tyoe","button").addClass("btn btn-default").css({'width':'100%'});
        if (language=='en') {
            btnClear.text('Clear');
            btnClose.text('Close');
        }
        else {
            btnClear.text('ล้าง');
            btnClose.text('ปิด');
        }
        tableA.append(tr);

        btnClear.on('click',function() {
            date_input.val('').attr('date_value',null);
        });

        btnClose.on('click',function() {
            closeCalendar();
        });
    }

    function makeDateData(today) {
        // https://www.w3schools.com/js/js_date_methods.asp
        // getDay 0=sunday
        // getMonth 0=มกราคม
        var todaySplit=today.split('-');
        var thisDay=todaySplit[2];
        var thisMonth=todaySplit[1];
        var thisMonthName='';
        if (language=='en') {
            var thisMonthName=enMonth(todaySplit[1]);
        }
        else {
            var thisMonthName=thMonth(todaySplit[1]);
        }

        var thisYear=todaySplit[0];
        var dateToday=new Date(today);
        var daysInThisMonth=new Date(thisYear, parseInt(thisMonth), 0).getDate();

        var dateLastMonth = new Date(thisYear, parseInt(thisMonth)-1, 15);
        dateLastMonth.setMonth(dateLastMonth.getMonth()-1); 
        var monthLastMonth=dateLastMonth.getMonth();
        var yearLastMonth=dateLastMonth.getFullYear();
        var daysInLastMonth=new Date(yearLastMonth, monthLastMonth+1, 0).getDate();

        var firstDayInweek=new Date(thisYear, parseInt(thisMonth)-1, 1).getDay();
        var firstDateInThisBox=daysInLastMonth-firstDayInweek+1;
        var lastDateOfFirstWeek;
        var weekList=[];
        var obFirstWeek=[];
        for (var i=firstDateInThisBox;i<=daysInLastMonth;i=i+1) {
            var ob={};
            ob['day']=i;
            ob['date_db']=yearLastMonth+'-'+addZero(monthLastMonth+1,2)+'-'+addZero(i,2);
            ob['full_th']=fullThaidate(yearLastMonth+'-'+addZero(monthLastMonth+1,2)+'-'+addZero(i,2));
            ob['other_month']=true;
            obFirstWeek.push(ob);
        }
        for (var i=1;i<=7-firstDayInweek;i=i+1) {
            lastDateOfFirstWeek=i;
            var ob={};
            ob['day']=i;
            ob['date_db']=thisYear+'-'+thisMonth+'-'+addZero(i,2);
            ob['full_th']=fullThaidate(thisYear+'-'+thisMonth+'-'+addZero(i,2));
            ob['other_month']=false;
            obFirstWeek.push(ob);
        }

        weekList.push(obFirstWeek);
        var weeksInThisMonth=Math.ceil((daysInThisMonth-lastDateOfFirstWeek)/7);
        var ld=f;
        for (var i=0;i<weeksInThisMonth-1;i=i+1) {
            var f=lastDateOfFirstWeek;
            var w=[];
            for (var n=1;n<=7;n=n+1) {
                ld=(i*7)+f+n;
                var ob={};
                ob['day']=ld;
                ob['date_db']=thisYear+'-'+thisMonth+'-'+addZero(ld,2);
                ob['full_th']=fullThaidate(thisYear+'-'+thisMonth+'-'+addZero(ld,2));
                ob['other_month']=false;
                w.push(ob);
            }
            weekList.push(w);
        }

        if (ld+1<=daysInThisMonth) {
            var lastWeek=[];
            for (var i=ld+1;i<=daysInThisMonth;i=i+1) {
                var ob={};
                ob['day']=i;
                ob['date_db']=thisYear+'-'+thisMonth+'-'+addZero(i,2);
                ob['full_th']=fullThaidate(thisYear+'-'+thisMonth+'-'+addZero(i,2));
                ob['other_month']=false;
                lastWeek.push(ob);
            }

            var dateNextMonth = new Date(thisYear, parseInt(thisMonth)-1, 15);
            dateNextMonth.setMonth(dateNextMonth.getMonth()+1); 
            var monthNextMonth=dateNextMonth.getMonth()+1; 
            var yearNextMonth=dateNextMonth.getFullYear();
            var x=7-lastWeek.length;
            for (var i=1;i<=x;i=i+1) {
                var ob={};
                ob['day']=i;
                ob['date_db']=yearNextMonth+'-'+addZero(monthNextMonth,2)+'-'+addZero(i,2);
                ob['full_th']=fullThaidate(yearNextMonth+'-'+addZero(monthNextMonth,2)+'-'+addZero(i,2));
                ob['other_month']=true;
                lastWeek.push(ob);
            }
            weekList.push(lastWeek);
        }
        var r={};
        r['dbYear']=thisYear.toString();
        r['thaiYear']=(parseInt(thisYear)+543).toString();
        r['monthName']=thisMonthName;
        r['data']=weekList;
        return r;
    }

    function fullThaidate(x) {
        var r="";
        var a=x.split('-');
        var mmm='';
        var yyy='';
        if (language=='en') {
            mmm=enMonth(a[1]);
            yyy=(parseInt(a[0])+0).toString();
        }
        else {
            mmm=thMonth(a[1]);
            yyy=(parseInt(a[0])+543).toString();
        }
        r=parseInt(a[2]).toString()+" "+mmm+" "+yyy;
        return r;
    }

    function addZero(x,n) {
        var l=x.toString().length;
        var r=x.toString();
        var z="";
        if (n-l>0) {
            for (var i=0;i<n-l;i=i+1) {
                z='0'+z;
            }
            r=z+x;
        }
        return r;
    }

    function thMonth(x) {
        var r="";
        switch (parseInt(x)) {
            case 1: r="มกราคม"; break;
            case 2: r="กุมภาพันธ์"; break;
            case 3: r="มีนาคม"; break;
            case 4: r="เมษายน"; break;
            case 5: r="พฤษภาคม"; break;
            case 6: r="มิถุนายน"; break;
            case 7: r="กรกฎาคม"; break;
            case 8: r="สิงหาคม"; break;
            case 9: r="กันยายน"; break;
            case 10: r="ตุลาคม"; break;
            case 11: r="พฤศจิกายน"; break;
            case 12: r="ธันวาคม"; break;
            default: break;
        }
        return r;
    }

    function enMonth(x) {
        var r="";
        switch (parseInt(x)) {
            case 1: r="January"; break;
            case 2: r="February	"; break;
            case 3: r="March"; break;
            case 4: r="April"; break;
            case 5: r="May"; break;
            case 6: r="June"; break;
            case 7: r="July"; break;
            case 8: r="August"; break;
            case 9: r="September"; break;
            case 10: r="October"; break;
            case 11: r="November"; break;
            case 12: r="December"; break;
            default: break;
        }
        return r;
    }
}