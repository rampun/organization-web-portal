require('./bootstrap');


jQuery( function() {
    jQuery( ".custom_date_picker" ).datetimepicker(
      {
        timepicker:false,
        format:'Y-m-d'
      }
    );

    // event date picker
    jQuery( ".custom_event_date_picker" ).datetimepicker(
      {
        format:'Y-m-d H:i',
        // minDate:0,
        allowTimes:[
          '7:00', '8:00', '9:00', '10:00', '11:00', '12:00', 
          '13:00', '14:00', '15:00', '16:00', '17:00', '18:00',
          '19:00', '20:00', '21:00', '22:00', '23:00', '00:00'
         ]
      }
    );

    // initiate lightbox
      // jQuery('.lightBoxedImage').lightbox()

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });



    // function to auto close the alert messages
      setTimeout(function(){
         $("div.alert").remove();
      }, 3000 ); // 5 secs

    /**
     * Nepal Address related
     */
        // hide all the districts on first load
        jQuery('.np_districts').hide();
        // show related Districts on region select
        jQuery('#province_np').on('change',function(){
        // hide all districts at first
        jQuery('.np_districts').hide();
        // show the related districts only
        var selected_id = jQuery(this).children(":selected").attr("id");
        jQuery('.'+selected_id).show();
      })

      /**
     * Hong Kong Address related
     */
        // hide all the districts on first load
        jQuery('.hk_districts').hide();
        // show related Districts on region select
        jQuery('#region_hk').on('change',function(){
        // hide all districts at first
        jQuery('.hk_districts').hide();
        // show the related districts only
        var selected_id = jQuery(this).children(":selected").attr("id");
        jQuery('.'+selected_id).show();
      })



      // call searchFunction 
      function searchFilterMember()
      {
        var search_key = jQuery('#search_member__input').val();
        var family_name = jQuery('#filter_by_family_name').val();
        var district_hk = jQuery('#filter_by_district_hk').val();
        var district_np = jQuery('#filter_by_district_np').val();
        var job = jQuery('#filter_by_job').val();
        var formData = {
          search_key: search_key,
          family_name: family_name,
          district_hk: district_hk,
          district_np: district_np,
          job: job
        };

      var ajaxurl = 'member/search';
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: formData,
          dataType: 'json',
          beforeSend: function()
          {
            jQuery('.pms_loading').show();
          },
          success: function (response) {
            var html = '';

            data = response['data'];
            jQuery('.pms_loading').hide();
            // console.log(data)
            if(data.length)
            {
              var i=1;
                $.each(data, function(key, value)
                {
                  html += `<tr>
                  <th scope="row">`+ i++ +`</th>
                    <td><a href="`+'/member/detail/'+value['id']+`">`+value['name']+`</a></td>
                    <td>`+value['email']+`</td>
                    <td>` +value['mobile_no'] + `</td>
                    <td>
                    <a href="`+'/member/update/'+value['id']+`">
                      Edit
                    </a>&nbsp;|&nbsp;
                    <a href="`+'/member/delete/'+value['id']+`">
                      Delete
                    </a>
                    </td>
                  </tr>`;
                })
            }
            else {
              html += `<tr>
                <td colspan="8">No Data</td>
              </tr>`;
            }

              jQuery('#dynamic_members').html(html);
              // add total count
              if(data.length >1)
              {
                members_found = 'members found';
              }
              else {
                members_found = 'member found';
              }
              jQuery('#search_count').html(data.length + ' ' + members_found)
          },
          error: function (data) {
              // console.log(data);
          }
      });
      }

      // search member function
      jQuery('#search_member__input').on('input', function(e)
      {    
        e.preventDefault();
        searchFilterMember();
      })

      // on select family name
      jQuery('#filter_by_family_name').on('change', function(e){
        e.preventDefault();
        searchFilterMember();
      })

      // on select district HK
      jQuery('#filter_by_district_hk').on('change', function(e){
        e.preventDefault();
        searchFilterMember();
      })

      // on select district NP
      jQuery('#filter_by_district_np').on('change', function(e){
        e.preventDefault();
        searchFilterMember();
      })

       // on select Job
       jQuery('#filter_by_job').on('change', function(e){
        e.preventDefault();
        searchFilterMember();
      })

      loadRemoteData();
      
      function loadRemoteData()
      {
        // dynamic list members
      $(".listMembers").select2({
        ajax: {
          url: 'https://pms.weavetechlabs.xyz/member/search',
          dataType: 'json',
          delay: 250,
          type: 'POST',
          data: function (params) {
            return {
              search_key: params.term, // search term
            };
          },
          processResults: function (response, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON response, except to indicate that infinite
            // scrolling can be used
      

            // console.log(response)
            return {
              results: response['data'],
            };
          },
          cache: true
        },
        placeholder: 'Search for a member',
        minimumInputLength: 3,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
      });
      }
      
      function formatRepo (member) {
        if (member.loading) {
          return member.text;
        }
      
        
      var $container = $(
        "<div class='select2-result-member clearfix'>" +
          "<div class='select2-result-member__avatar'><img src='https://pms.weavetechlabs.xyz/uploads/members/" + member.id + '/'+ member.member_photo + "' style='width: 40px;float: left;margin-right: 5px;'/></div>" +
          "<div class='select2-result-member__meta'>" +
            "<div class='select2-result-member__title'></div>" +
            "</div>" +
          "</div>" +
        "</div>"
      );
      
        $container.find(".select2-result-member__title").text(member.name);
      
        return $container;
      }
      
      function formatRepoSelection (member) {
        return member.name || member.text;
      }

      // dynamically create element for Sub Department
      var j = 0;
      jQuery('#addSubdepartment').on('click',function(e){
        var subDepartment = `
        <div class="form-row coordinatorSubDepWrapperClass" id="coordinatorSubDep`+ j +`">
          <div class="form-group col-md-4">
          <label for="name">
            Name *
        </label>
          <input type="text" class="form-control">
        </div>

        <div class="form-group col-md-4">
          <label for="coordinator">
            Coordinator *
          </label>

          <select class="form-control listMembers" >
          </select>
        </div>
        <div class="col-md-4">
        <a class="d-none d-sm-inline-block btn btn-sm shadow-sm btn btn-outline-warning coordinatorSubDep" data-id="coordinatorSubDep`+ j +`"> Remove </a>
        </div>
      </div>
      `;

        jQuery('#subDepartmentSection').append(subDepartment);

        // reinitialize select2
        loadRemoteData();

        j++; 

      })

      jQuery(document).on('click','.coordinatorSubDep', function(){
        var id = jQuery(this).data('id');
        console.log(id)
        jQuery('#'+id).remove();
      })

      jQuery('#saveDepartment').on('click', function(event){
        event.preventDefault();

        var depart_meta = new Array();
        jQuery('.coordinatorSubDepWrapperClass').each(function(){
          var depart_name = jQuery(this).find('input').val();
          var coordinator = jQuery(this).find('select').val();
          if(depart_name && coordinator)
          {
            let depart_obj = {
              "name" : depart_name,
              "coordinator" : coordinator
            };
            // depart_obj.name = depart_name;
            // depart_obj.coordinator = coordinator;
            depart_meta.push(depart_obj);
          }
        })
        console.log(JSON.stringify(depart_meta))
        jQuery('input#department_meta').val(JSON.stringify(depart_meta));

        jQuery('form#departmentForm').trigger('submit');
      })
  });
