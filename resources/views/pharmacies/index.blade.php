@extends('admin.index')
@section('title','Pharmacy')
@section('section_title','Pharmacy')
@section('content')

<div class="container my-3">
    <a href="{{route('pharmacies.create')}}" class="edit btn btn-primary btn-sm">Add Pharmacy</a>
    <br>
    <br>
 
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                  <th>ID</th>
                  <th>national_id</th>
                  <th>Pharmacy_Name</th>
                  <th>Image</th>
                  <th>Email</th>
                  <th>priority</th>
                  <th>Area ID</th>
                 <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<!-- attia -->
<!-- alret form to confirm delete  -->
<div class="modal model-danger fade" id="delete" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content confirmModal">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>

            <form method="post" action="" id="formdelete">
                <div class="modal-body">

                    @csrf
                    @method('delete')
                    <div>
                        <div class="box-body">
                            <p class="text-center">Are u sure want to delete?</p>


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">No, cancel</button>
                    <button type="submit" class="btn btn-success">Yes,
                        Delete</button>
                </div>
            </form>
            <!--  -->


        </div>
    </div>
</div>
<!--///////////////////end form  -->
</body>
@endsection
@section('script')
<script type="text/javascript">
    $(function () {

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pharmacies.index') }}",
            columns: [
              {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'national_id',
                    name: 'national_id'
                },
                {
                    data: 'pharmacy_name',
                    name: 'pharmacy_name'
                },
                {
                    data: 'img',
                    name: 'img',
                    render:function(data){ return "<img width='50px' height='50px' src='/storage/"+ data + "' />";}

                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'priority',
                    name: 'priority'
                },
           
                {
                    data: 'area_id',
                    name: 'area_id'
                },
                 {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        $(document).on("click", ".del", function () {
            var id = $(this).data('id');
            var deleteForm = document.getElementById("formdelete") // get form 
            deleteForm.action = '/pharmacies/' + id; // assign action 

        });
    });

</script>

@endsection 