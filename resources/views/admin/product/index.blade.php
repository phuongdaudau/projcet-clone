@extends('layouts.admin.app')

@section('title','List')

@section('content')
<div class="">
   <div class="clearfix"></div>
   <div class="block-header">
      <a class="btn btn-primary waves-effect" href="{{ route('admin.product.create') }}">
            <i class="material-icons">add</i>
      </a>
   </div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>List Product</small></h2>
               <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                     <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                     </ul>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
               </ul>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <table id="list-data" class="table table-striped table-bordered bulk_action">
               <form action="{{ route('admin.product.index) }}" method="GET">
                  <label><select name="datatable-checkbox_length" aria-controls="datatable-checkbox" class="form-control input-sm">
                     <option value="0" selected disabled>Show entries</option>
                     <option value="10">10</option>
                     <option value="25">25</option>
                     <option value="50">50</option>
                     <option value="100">100</option>
                  </select></label>
            </form>
                  <label style="float: right;"><input type="search" class="form-control input-sm" placeholder="Search for ..." aria-controls="datatable-checkbox"></label>
                  <thead>
                     <tr>
                        <th>
                          <th><input type="checkbox" id="check-all" class="flat"></th>
                        </th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Created date</th>
                        <th>Updated date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody id="show-entries">
                     @php($i=1)
                     @foreach($products as $product)
                     <tr>
                        <td>{{$i}}
                        <th><input type="checkbox" id="check-all" class="flat"></th>
                        </td>
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->quantity}}</td>
                        <td>{{$product->created_at}}</td>
                        <td>{{$product->updated_at}}</td>
                        <td class ="text-center">
                           <a href="{{ route('admin.product.show', $product->id)}} " class= "btn btn-success waves-effect">
                                 <i class ="material-icons">visibility</i>
                           </a>
                           <a href="{{ route('admin.product.edit', $product->id)}} " class= "btn btn-info waves-effect">
                                 <i class ="material-icons">edit</i>
                           </a>
                           <button class= "btn btn-danger waves-effect" type="button" onclick="deleteproduct({{ $product->id }})">
                                 <i class="material-icons">delete</i>
                           </button>
                           <form id="delete-form-{{ $product->id }}" action=" {{ route('admin.product.destroy', $product->id)}}" method="POST" style="display: none;">
                                 @csrf
                                 @method('DELETE')
                           </form>
                        </td>
                     </tr>
                     @php($i++)
                     @endforeach
                  </tbody>
               </table>
               <div>
                     <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                        <ul class="pagination">
                           <li class="paginate_button previous disabled" id="datatable_previous">
                              <a href="#" aria-controls="datatable" data-dt-idx="0" tabindex="0">Previous</a>
                           </li>
                           <li class="paginate_button active">
                              <a href="#" aria-controls="datatable" data-dt-idx="1" tabindex="0">1</a>
                           </li>
                           <li class="paginate_button ">
                              <a href="#" aria-controls="datatable" data-dt-idx="2" tabindex="0">2</a>
                           </li>
                           <li class="paginate_button ">
                              <a href="#" aria-controls="datatable" data-dt-idx="3" tabindex="0">3</a>
                           </li>
                           <li class="paginate_button ">
                              <a href="#" aria-controls="datatable" data-dt-idx="4" tabindex="0">4</a>
                           </li><li class="paginate_button ">
                              <a href="#" aria-controls="datatable" data-dt-idx="5" tabindex="0">5</a>
                           </li><li class="paginate_button ">
                              <a href="#" aria-controls="datatable" data-dt-idx="6" tabindex="0">6</a>
                           </li><li class="paginate_button next" id="datatable_next">
                              <a href="#" aria-controls="datatable" data-dt-idx="7" tabindex="0">Next</a>
                           </li>
                        </ul>
                     </div>
                  </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">
        function deleteproduct(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success',
                  cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
              })
              
              swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {
                  event.preventDefault();
                  document.getElementById('delete-form-'+id).submit();
                } else if (
                  /* Read more about handling dismissals below */
                  result.dismiss === Swal.DismissReason.cancel
                ) {
                  swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your data is safe :)',
                    'error'
                  )
                }
              })
        }
        
    </script>
@endpush