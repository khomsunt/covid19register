$.fn.datepickerSkn = function(today,v){
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
    var todaySplit=today.split('-');
    var thisDay=todaySplit[2];
    var thisMonth=todaySplit[1];
    var thisMonthName=thMonth(todaySplit[1]);
    var thisYear=todaySplit[0];

    // https://www.w3schools.com/js/js_date_methods.asp
    var dateToday=new Date(today);
    var daysInThisMonth=new Date(thisYear, parseInt(thisMonth), 0).getDate();
    var dateLastMonth = new Date();
    dateLastMonth.setMonth(dateLastMonth.getMonth()-1);
    var daysInLastMonth=new Date(dateLastMonth.getFullYear(), dateLastMonth.getMonth()+1, 0).getDate();
    // getDay 0=sunday
    var firstDayInweek=new Date(thisYear, parseInt(thisMonth)-1, 1).getDay();
    var firstDateInThisBox=daysInLastMonth-firstDayInweek+1;
    var lastDateOfFirstWeek;
    var weekList=[];
    var firstWeek=[];
    var obFirstWeek=[];
    for (var i=firstDateInThisBox;i<=daysInLastMonth;i=i+1) {
        firstWeek.push(i);
        var ob={};
        ob['day']=i;
        ob['date_db']=thisYear+'-'+thisMonth+'-'+addZero(i,2);
        ob['full_th']=fullThaidate(thisYear+'-'+thisMonth+'-'+addZero(i,2));
        obFirstWeek.push(ob);
    }
    for (var i=1;i<=7-firstDayInweek;i=i+1) {
        firstWeek.push(i);
        lastDateOfFirstWeek=i;
        ob['day']=i;
        ob['date_db']=thisYear+'-'+thisMonth+'-'+addZero(i,2);
        ob['full_th']=fullThaidate(thisYear+'-'+thisMonth+'-'+addZero(i,2));
        obFirstWeek.push(ob);
    }
    console.log(obFirstWeek);
    weekList.push(firstWeek);
    var weeksInThisMonth=Math.ceil((daysInThisMonth-lastDateOfFirstWeek)/7);
    var ld=f;
    for (var i=0;i<weeksInThisMonth-1;i=i+1) {
        var f=lastDateOfFirstWeek;
        var w=[];
        for (var n=1;n<=7;n=n+1) {
            ld=(i*7)+f+n;
            w.push(ld);
        }
        weekList.push(w);
    }

    if (ld+1<=daysInThisMonth) {
        var lastWeek=[];
        for (var i=ld+1;i<=daysInThisMonth;i=i+1) {
            lastWeek.push(i);
        }
        var x=7-lastWeek.length;
        for (var i=1;i<=x;i=i+1) {
            lastWeek.push(i);
        }
        weekList.push(lastWeek);
    }

    var tableA=$('<table>');
    var tdWidth=Math.floor(masterWidth/7);

    var trTitle=$('<tr>');
    var tdLeft=$('<td>');
    var tdTitle=$('<td>');
    var tdRight=$('<td>');
    trTitle.append(tdLeft);
    trTitle.append(tdTitle);
    trTitle.append(tdRight);

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
    tdTitle.attr('colspan',5).text(thisMonthName).css({'height':'40px', 'width': (masterWidth-(tdWidth*5))+'px', 'text-align':'center'});
    tdRight.css({'width': tdWidth+'px', 'text-align':'center'});

    weekList.forEach(w => {
        var trHead=$('<tr>');
        w.forEach(i => {
            var td=$('<td>');
            td.addClass('dayCell').text(i).css({'height':'40px', 'width': tdWidth+'px', 'text-align':'center'});
            trHead.append(td);
        });
        tableA.append(trHead);
    });

    $(".dayCell").click(function() {
        console.log($(this).text());
    });
 
    function fullThaidate(x) {
        console.log(x);
        var r="";
        var a=x.split('-');
        r=parseInt(a[2]).toString()+" "+thMonth(a[1])+" "+(parseInt(a[0])+543).toString();
        return r;
    }

    function addZero(x,n) {
console.log(x);
        var l=x.length;
        var r="";
        if (n-l>0) {
            for (var i=0;i<n-l;i=i+1) {
                r=''+r;
            }
            r=r+x;
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
            case 12: r="ธัันวาคม"; break;
            default: break;
        }
        return r;
    }
}