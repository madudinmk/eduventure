
$(document).ready(function() {

  refreshList();

  $('#refresher').click(function(event) {
      event.preventDefault();
      refreshList();
  });

  $(document).on('click', '#viewDetails', function(e) {
    e.preventDefault();
    var rid = $(this).data('id');
    refreshModal(rid);
  });

  function refreshModal(rid) {
    $('#dynamic-content').hide();
    $('#modal-loader').show();
    $.ajax({
      url: 'response.php?action=list',
      type: 'GET', // GET request is default, optional to insert
      data: { id: rid },
      dataType: 'json'
    })
    .done(function(data) {
      console.log(data); 
      $('#dynamic-content').hide(); // hide dynamic div
      $('#dynamic-content').show(); // show dynamic div
      $('#txt_id').html(data.reservation_id);
      $('#txt_name').html(data.name);
      $('#txt_email').html(data.email);
      $('#txt_phone').html(data.phone);
      $('#txt_guests').html(data.guests);
      $('#txt_timestamp').html(data.booking_timestamp);
      $('#txt_status').html(data.booking_status);
      //$('#delete_data').attr("href", 'admin_panel_bootstrap.php?del='+$('td#txt_id').text());
        switch(data.booking_status) {
        case 'Confirmed':
          $("span#bull_status").attr("class", 'text-success');
          $("span#bull_status").addClass('status');
          $("span#btn-status").html('');
          break;
        case 'Denied':
          $("span#bull_status").attr("class", 'text-danger');
          $("span#bull_status").addClass('status');
          $("span#btn-status").html('');
          break;
        case 'Pending':
          $("span#bull_status").attr("class", 'text-warning');
          $("span#bull_status").addClass('status');
          $("span#btn-status").html('<a id="modal-btn" class="btn btn-success btn-xs" data-status="Confirmed">Confirm</a> <a id="modal-btn" class="btn btn-danger btn-xs" data-status="Denied">Deny</a>');
          break;
            }
      $('#modal-loader').hide();
    })
    .fail(function() {
      $('.modal-body').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong. Please try again...');
    });
  }

  function refreshList() {
    $('#tbl-listing').hide();
    $('#refresh-loader').show();
    $.ajax({
      type: 'GET',
      cache: false,
      url: "response.php?action=lists"
    })
    .done(function(result) {
      result = JSON.parse(result);
      console.log(result); // Log incoming results
      //$('#tbl-listing').hide();
      $('#tbl-listing').show();
      var textToInsert = '';
      var id, reservation_id, name, checkin, checkout, status = '';
      var span_status = '';
      var i = 1;
      $.each(result, function(row, rowdata) {
        $.each(rowdata, function (idx, eledata) {
    
          if(idx === 'reservation_id') {
            reservation_id = eledata;
          }
          if(idx === 'name') {
            name = eledata;
          }
          if(idx === 'checkin') {
            checkin = eledata;
          }
          if(idx === 'checkout') {
            checkout = eledata;
          }
          if(idx === 'booking_status') {
            status = eledata;

            switch (status) {
              case 'Pending':
                span_status = '<span class="status text-warning">&bull;</span>'+status;
                break;
              case 'Confirmed':
                span_status = '<span class="status text-success">&bull;</span>'+status;
                break;
              case 'Denied':
                span_status = '<span class="status text-danger">&bull;</span>'+status;
                break;
            }
          }
        });
        textToInsert += '<tr data-status="' + status + '">';
        textToInsert  += '<td>' + i + '</td><td>' + reservation_id + '</td><td>' + name + '</td><td>' + checkin + '</td><td>' + checkout + '</td><td>' + span_status + '</td>';

        textToInsert += '<td><a href="#" id="viewDetails" class="view" data-toggle="modal" data-target="#editEmployeeModal" data-id="' +reservation_id + '"><i class="material-icons" data-toggle="tooltip" title="View Details">&#xE5C8;</i></a></td>';
        textToInsert += '</tr>';
        i++;
      });
      $("#tbody-content").html(textToInsert);
      $('#refresh-loader').hide();
    })
    .fail(function(xhr, status) {
      $('#tbody-content').html('<div class="alert alert-danger">'+xhr.responseText+'</div>');
    });
  }

  $(document).on('click', '#modal-btn', function() {
    //e.preventDefault();
    var status = $(this).data('status');
    var rid = $('td#txt_id').text();
    var conf = confirm('Are you sure?');
    if(conf) {
      $.ajax({
        url: 'response.php?action=status',
        type: 'POST', // GET request is default, optional to insert
        data: { id: rid, stat: status }

      })
      .done(function() {
        refreshModal(rid);
        setTimeout(refreshList, 1000);
      })
      .fail(function() {
        $('.modal-body').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong. Please try again...');
      });
    }
  });

  $(document).on('click', '#delete_data', function() {
    var rid = $('td#txt_id').text();
    var conf = confirm('Are you sure to delete?');
    if(conf) {
      $.ajax({
        url: 'response.php?action=delete',
        type: 'POST',
        data: { id: rid }
      })
      .done(function() {
        $('#editEmployeeModal').modal('toggle');
        setTimeout(refreshList, 1000);
      })
      .fail(function(xhr, status) {
        $('.modal-body').html('<div class="alert alert-danger">'+xhr.responseText+'</div>');
      });
    }
  });

});