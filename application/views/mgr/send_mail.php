
<style>
    .modal-body input{
        font-size: 16px !important;
        text-align: center !important;
        font-weight: normal !important;
    }
    .modal-body textarea{
        width: 100%;
        height: 80px;
    }
    .send_mail{
        cursor: pointer;
        color: #6699cc;
    }
</style>
<!-- Cover Modal -->
<div class="modal fade" id="mailModal" role="dialog" aria-labelledby="modalLabel" tabindex="-1" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalLabel" style="text-align: center;">
            寄送信件
        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-sm-12">
                <div class="form-group">
                    <input type="text" class="form-control subject" placeholder="信件主旨">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-sm-12">
                <div class="form-group">
                    <input type="text" class="form-control email" placeholder="收件人email">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-sm-12">
                <div class="form-group">
                    <label>內容</label>
                    <textarea name="content" placeholder="" class="form-control content"></textarea>
                </div>
            </div>
        </div>

      </div>
      <div class="modal-footer" style="text-align: center;">
        <button id="sendmail" style="width: 60%;" type="button" class="btn btn-danger">確定送出</button>
      </div>
    </div>
  </div>
</div>
<!-- Cover Modal -->

<script>
    $(document).ready(function($) {
        
        $("#sendmail").on('click', function(event) {
            
            var subject = $("#mailModal .modal-body .subject").val();
            var email   = $("#mailModal .modal-body .email").val();
            var content = $("#mailModal .modal-body .content").val();

            $.ajax({
                url: "<?= base_url() ?>mgr/dashboard/send_email",
                data: {
                    subject: subject,
                    email: email,
                    content: content
                },
                type: "POST",
                dataType: "json",
                success: function(msg){
                    alert(msg.msg);
                },
                error:function(xhr, ajaxOptions, thrownError){ 
                    alert(xhr.status); 
                    alert(thrownError); 
                },
                complete:function(){
                    $("#mailModal").modal("hide");

                    $("#mailModal .modal-body .subject").val("");
                    $("#mailModal .modal-body .email").val("");
                    $("#mailModal .modal-body .content").val("");
                }
            });
        });

    });

</script>