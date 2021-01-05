﻿$.fn.datepickerSkn = function(today,v){
    var date_input=this;

    var dayList=['อา','จ','อ','พ','พฤ','ศ','ส'];
    // var offset = this.offset();
    // var height = this.outerHeight(false);
    var masterWidth = this.outerWidth(false);
    // var left = offset.left;
    // var top = offset.top;
    var left = this.left;
    var top = this.top;
    var divMother=$('<div>');
    divMother.css({
        'padding':'3px',
        'background-color':'white', 
        'border-radius':'5px', 
        'border':'solid 1px #999999', 
        'box-shadow': '0px 4px 10px #cccccc', 
        'position':'absolute', 
        'z-index':'50',
        'top': top+'px',
        'left': left+'px',
        'width': masterWidth+'px',
    });
    this.parent().append(divMother);
    var tableA=$('<table>');
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
    tdLeft.css({'padding':'2px'}).append(divTdLeft);
    tdRight.text('>').css({'font-weight':'bold'});
    divTdLeft.text('<').css({'font-weight':'bold', 'border': 'solid 1px red'});

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


    var dates=makeDateData(today);

    tdTitle.text(dates.monthName);

    dates.data.forEach(w => {
        var trHead=$('<tr>');
        w.forEach(i => {
            var td=$('<td>');
            td.addClass('dayCell').text(i.day).attr({'date_db':i.date_db, 'full_th':i.full_th}).css({'height':'40px', 'width': tdWidth+'px', 'text-align':'center'});
            trHead.append(td);
        });
        tableA.append(trHead);
    });

    $(".dayCell").click(function() {
        console.log($(this).attr('date_db'),'|',$(this).attr('full_th'));
        date_input.val($(this).attr('full_th'));
    });
 
    function makeDateData(today) {
        // https://www.w3schools.com/js/js_date_methods.asp
        // getDay 0=sunday
        // getMonth 0=มกราคม
        var todaySplit=today.split('-');
        var thisDay=todaySplit[2];
        var thisMonth=todaySplit[1];
        var thisMonthName=thMonth(todaySplit[1]);
        var thisYear=todaySplit[0];
        var dateToday=new Date(today);
        var daysInThisMonth=new Date(thisYear, parseInt(thisMonth), 0).getDate();

        var dateLastMonth = new Date(thisYear, parseInt(thisMonth)-1, 15);
        console.log(dateLastMonth);
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
            obFirstWeek.push(ob);
        }
        for (var i=1;i<=7-firstDayInweek;i=i+1) {
            lastDateOfFirstWeek=i;
            var ob={};
            ob['day']=i;
            ob['date_db']=thisYear+'-'+thisMonth+'-'+addZero(i,2);
            ob['full_th']=fullThaidate(thisYear+'-'+thisMonth+'-'+addZero(i,2));
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
                lastWeek.push(ob);
            }

            var dateNextMonth = new Date(thisYear, parseInt(thisMonth)-1, 15);
            dateNextMonth.setMonth(dateNextMonth.getMonth()+1); // getMonth 0=มกราคม
            var monthNextMonth=dateNextMonth.getMonth()+1; // getMonth 0=มกราคม
            var yearNextMonth=dateNextMonth.getFullYear();
            var x=7-lastWeek.length;
            for (var i=1;i<=x;i=i+1) {
                var ob={};
                ob['day']=i;
                ob['date_db']=yearNextMonth+'-'+addZero(monthNextMonth,2)+'-'+addZero(i,2);
                ob['full_th']=fullThaidate(yearNextMonth+'-'+addZero(monthNextMonth,2)+'-'+addZero(i,2));
                lastWeek.push(ob);
            }
            weekList.push(lastWeek);
        }
        var r={};
        r['monthName']=thisMonthName;
        r['data']=weekList;
        return r;
    }

    function fullThaidate(x) {
        var r="";
        var a=x.split('-');
        r=parseInt(a[2]).toString()+" "+thMonth(a[1])+" "+(parseInt(a[0])+543).toString();
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
}