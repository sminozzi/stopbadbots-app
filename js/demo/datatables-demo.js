// Call the dataTables jQuery plugin
$(document).ready(function () {
  $("td").click(function (event) {
    //var id = $(this).data('uid');
    //var $id = "#" + id;
    // var name = $('#id').val();
    // var botname = $("#id").val();
    var tableName = $(this).closest('table').attr('id');

    // alert(tableName);

    //console.log(tableName);

    if (tableName == 'dataTableIP') {
      // var ip = $(this).data('ip');
     // console.log(ip);
      var state = $(this).data('state');
      var ip = $(this).attr('id');
      $('#editRecordIP').modal({ show: true });
      if (state == 'Enabled') {
        $(".modal-body").html("Disable Bot: " + ip + '?');
      }
      else {
        $(".modal-body").html("Enable Bot: " + ip + '?');
      }
 
      $("#state").val(state);
      $("#ip").val(ip);

    }

    if (tableName == 'dataTable') {
      var name = $(this).data('name');
      // console.log(name);
 
     // alert(name);



      var state = $(this).data('state');
      $('#editRecord').modal({ show: true });
      if (state == 'Enabled') {
        $(".modal-body").html("Disable Bot: " + name + '?');
      }
      else {
        $(".modal-body").html("Enable Bot: " + name + '?');
      }

      $("#name").val(name);
      $("#state").val(state);



    }

    if (tableName == 'dataTableREF') {
      var name = $(this).data('name2');
      var state = $(this).data('state');
      $('#editRecordREF').modal({ show: true });
      if (state == 'Enabled') {
        $(".modal-body").html("Disable Bot: " + name + '?');
      }
      else {
        $(".modal-body").html("Enable Bot: " + name + '?');
      }

      // alert($name);

      $("#name9").val(name);
      $("#state").val(state);


    }


    /*
        var state = $(this).attr("class");
        // var state = $(this).data('state');
        // console.log(state);
        var nickname = $($id).html();
    */
    // console.log(state);
    if (typeof name === 'undefined') {
      // return;
    }





  }); // End Click Row


  $('#update-state').click(function (evt) {
    var myid = evt.target.id;
    var name = $("#name").val();
    var state = $("#state").val();
    //console.log(name);
    //console.log(state);
    if (evt.target.id == myid) {
      /*           
             console.log(evt.target.id); 
             console.log(evt.target.checked); 
             console.log($(evt.target).val()); // valor 
             console.log($('#flag1').val());     
     */
      // state == 'Enabled') 
      $.ajax(
        {
          url: '/stopbadbots/php/ajax.php',
          withCredentials: true,
          timeout: 15000,
          method: 'POST',
          crossDomain: false,
          data: {
            state: state,
            name: name,
            action: 'edit'
          },
          success: function (result) {
            // $("#div1").html(result); 
            // alert("ok"); 
            location.reload();
          }
        });
    } // if flag1  
  });
  $('#add-state').click(function (evt) {
    var name = $("input:text").val();
    // alert(name);
    $.ajax(
      {
        url: '/stopbadbots/php/ajax.php',
        withCredentials: true,
        timeout: 15000,
        method: 'POST',
        crossDomain: false,
        data: {
          action: 'add',
          name: name
        },
        success: function (result) {
          // $("#div1").html(result); 
          // alert("ok"); 
          location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          // alert(errorThrown);
          alert("Error");
        }
      });
  });
  $('#update-stateIP').click(function (evt) {
    var myid = evt.target.id;
    var ip = $("#ip").val();
    var state = $("#state").val();
    //console.log(ip);
    //console.log(state);
    if (evt.target.id == myid) {
      /*           
             console.log(evt.target.id); 
             console.log(evt.target.checked); 
             console.log($(evt.target).val()); // valor 
             console.log($('#flag1').val());     
     */
      // state == 'Enabled') 
      $.ajax(
        {
          url: '/stopbadbots/php/ajax.php',
          withCredentials: true,
          timeout: 15000,
          method: 'POST',
          crossDomain: false,
          data: {
            state: state,
            ip: ip,
            action: 'editIP'
          },
          success: function (result) {
            // $("#div1").html(result); 
            // alert("ok"); 
            location.reload();
          }
        });
    } // if flag1  
  });
  $('#add-stateIP').click(function (evt) {
    //  var ip = $("input:text").val();
    // var ip = $("#ip").val();
    var ip = document.getElementById('ip2').value;
    // alert('ip: ' + ip);
    $.ajax(
      {
        url: '/stopbadbots/php/ajax.php',
        withCredentials: true,
        timeout: 15000,
        method: 'POST',
        crossDomain: false,
        data: {
          action: 'addIP',
          ip: ip
        },
        success: function (result) {
          // $("#div1").html(result); 
          //alert("ok");
          location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          // alert(errorThrown);
          alert("Error");
        }
      });
  });
  $('#update-stateREF').click(function (evt) {
    var myid = evt.target.id;
   // var name = $("#name").val();
    var state = $("#state").val();
    var name = document.getElementById('name9').value;
   // console.log(state);
   // alert(name);

    if (evt.target.id == myid) {
      /*           
             console.log(evt.target.id); 
             console.log(evt.target.checked); 
             console.log($(evt.target).val()); // valor 
             console.log($('#flag1').val());     
     */
      // state == 'Enabled') 
      $.ajax(
        {
          url: '/stopbadbots/php/ajax.php',
          withCredentials: true,
          timeout: 15000,
          method: 'POST',
          crossDomain: false,
          data: {
            state: state,
            name: name,
            action: 'editREF'
          },
          success: function (result) {
            // $("#div1").html(result); 
            // alert("ok"); 
            location.reload();
          }
        });
    } // if flag1  
  });
  $('#add-stateREF').click(function (evt) {
    //  var ip = $("input:text").val();
    // var ip = $("#ip").val();
    var name = document.getElementById('name2').value;
    // alert('name: ' + name);
    $.ajax(
      {
        url: '/stopbadbots/php/ajax.php',
        withCredentials: true,
        timeout: 15000,
        method: 'POST',
        crossDomain: false,
        data: {
          action: 'addREF',
          name: name
        },
        success: function (result) {
          // $("#div1").html(result); 
        //  alert("ok");
          location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          // alert(errorThrown);
          alert("Error");
        }
      });
  });
  $('#dataTable').DataTable({
    deferRender:    true,
    /*
   
      "dom": '<"toolbar">frtip'
    } );
      $("div.toolbar").html('<b>Custom tool bar! Text/images etc.</b>');
    */
    dom: 'flBrtip', // "lBtipr","lBtipr",
    buttons: {
      buttons: [
        {
          text: "Add Bot",
          action: function (e, dt, node, config) {
            //trigger the bootstrap modal
            // alert();
            $('#addRecord').modal({ show: true });
          }
        }
      ],
      dom: {
        button: {
          tag: "button",
          className: "btn btn-primary"
        },
        buttonLiner: {
          tag: null
        }
      }
    }
  });
});
$('#dataTableIP').DataTable({
  deferRender:    true,
  /*

    "dom": '<"toolbar">frtip'
} );
$("div.toolbar").html('<b>Custom tool bar! Text/images etc.</b>');
*/
  dom: 'flBrtip', // "lBtipr","lBtipr",
  buttons: {
    buttons: [
      {
        text: "Add Bot",
        action: function (e, dt, node, config) {
          //trigger the bootstrap modal
          // alert();
          $('#addRecordIP').modal({ show: true });
        }
      }
    ],
    dom: {
      button: {
        tag: "button",
        className: "btn btn-primary"
      },
      buttonLiner: {
        tag: null
      }
    }
  }
});

$('#dataTableREF').DataTable({


//scrollY:        200,
deferRender:    true,
//scroller:       true,

  dom: 'flBrtip', // "lBtipr","lBtipr",
  buttons: {
    buttons: [
      {
        text: "Add Bot",
        action: function (e, dt, node, config) {
          //trigger the bootstrap modal
          // alert();
          $('#addRecordREF').modal({ show: true });
        }
      }
    ],
    dom: {
      button: {
        tag: "button",
        className: "btn btn-primary"
      },
      buttonLiner: {
        tag: null
      }
    }
  }
});
