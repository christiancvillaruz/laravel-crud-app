<div class="container p-5">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header justify-content-between">
          <h4 style="float: left">List of Students</h4>
          <button class="btn btn-sm btn-success" style="float: right" data-toggle="modal" data-target="#addStudentModal" wire:click="randomId"><i class="fa fa-plus"></i> Add New Student</button>
        </div>
        <div class="card-body">
          <div class="row">
            @if (session()->has('message'))
              <div class="col-md-12">
                <div class="alert alert-success">
                  <i class="fa fa-info-circle"></i>
                  {{ session('message') }}
                </div>
              </div>
            @endif
            <div class="col-md-12">
              <table class="table table-bordered table-striped table-responsive-lg" style="width: 100%" id="studentTbl">
                <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Mobile No.</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if($students->count() > 0)
                    @foreach ($students as $row)
                      <tr>
                        <td>{{ $row->student_id }}</td>
                        <td>{{ $row->student_fname }}</td>
                        <td>{{ $row->student_mname }}</td>
                        <td>{{ $row->student_lname }}</td>
                        <td>{{ $row->student_email }}</td>
                        <td>{{ $row->student_mobile }}</td>
                        <td class="text-center">
                          <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                              Options
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a href="#" class="dropdown-item" wire:click="viewStudentData({{ $row->id }})"><i class="fa fa-search"></i> View</a>
                              <a href="#" class="dropdown-item" wire:click="getStudentId({{ $row->id }})"><i class="fa fa-pencil"></i> Edit</a>
                              <a href="#" class="dropdown-item" wire:click="deleteConfirmation({{ $row->id }})"><i class="fa fa-times"></i> Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="7" style="text-align: center">No Students Found</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Add Modal -->
  <div wire:ignore.self class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form wire:submit.prevent="saveStudentData">
          <div class="modal-header">
            <h5 class="modal-title">Add New Student</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-primary" role="alert">
                  <em><i class="fa fa-info-circle" aria-hidden="true"></i> Fields marked with asterisk are required.</em>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="student_id" class="col-md-3 col-form-label label-required">Student ID</label>
              <div class="col-md-9">
                <input type="text" id="student_id" class="form-control" wire:model="student_id" readonly>
                @error('student_id')
                  <span class="text-danger">
                    {{ $message }}
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="student_fname" class="col-md-3 col-form-label label-required">First Name</label>
              <div class="col-md-9">
                <input type="text" id="student_fname" class="form-control" placeholder="First Name" wire:model="student_fname">
                @error('student_fname')
                  <span class="text-danger">
                    {{ $message }}
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="student_mname" class="col-md-3 col-form-label">Middle Name <small><em class="text-muted text-sm">Optional</em></small></label>
              <div class="col-md-9">
                <input type="text" id="student_mname" class="form-control" placeholder="Middle Name" wire:model="student_mname">
              </div>
            </div>
            <div class="form-group row">
              <label for="student_lname" class="col-md-3 col-form-label label-required">Last Name</label>
              <div class="col-md-9">
                <input type="text" id="student_lname" class="form-control" placeholder="Last Name" wire:model="student_lname">
                @error('student_lname')
                  <span class="text-danger">
                    {{ $message }}
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="student_email" class="col-md-3 col-form-label label-required">Email Address</label>
              <div class="col-md-9">
                <input type="email" id="student_email" class="form-control" placeholder="Email Address" wire:model="student_email">
                @error('student_email')
                  <span class="text-danger">
                    {{ $message }}
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="student_mobile" class="col-md-3 col-form-label label-required">Mobile No.</label>
              <div class="col-md-9">
                <input type="text" id="student_mobile" class="form-control" placeholder="Mobile No." wire:model="student_mobile">
                @error('student_mobile')
                  <span class="text-danger">
                    {{ $message }}
                  </span>
                @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-sm">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Edit Modal -->
  <div wire:ignore.self class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form wire:submit.prevent="editStudentData">
          <div class="modal-header">
            <h5 class="modal-title">Edit Student Information</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetForm">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
              <label for="student_id" class="col-md-3 col-form-label label-required">Student ID</label>
              <div class="col-md-9">
                <input type="text" id="student_id" class="form-control" wire:model="student_id" readonly>
                @error('student_id')
                  <span class="text-danger">
                    {{ $message }}
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="student_fname" class="col-md-3 col-form-label label-required">First Name</label>
              <div class="col-md-9">
                <input type="text" id="student_fname" class="form-control" placeholder="First Name" wire:model="student_fname">
                @error('student_fname')
                  <span class="text-danger">
                    {{ $message }}
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="student_mname" class="col-md-3 col-form-label">Middle Name <small><em class="text-muted text-sm">Optional</em></small></label>
              <div class="col-md-9">
                <input type="text" id="student_mname" class="form-control" placeholder="Middle Name" wire:model="student_mname">
              </div>
            </div>
            <div class="form-group row">
              <label for="student_lname" class="col-md-3 col-form-label label-required">Last Name</label>
              <div class="col-md-9">
                <input type="text" id="student_lname" class="form-control" placeholder="Last Name" wire:model="student_lname">
                @error('student_lname')
                  <span class="text-danger">
                    {{ $message }}
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="student_email" class="col-md-3 col-form-label label-required">Email Address</label>
              <div class="col-md-9">
                <input type="email" id="student_email" class="form-control" placeholder="Email Address" wire:model="student_email">
                @error('student_email')
                  <span class="text-danger">
                    {{ $message }}
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="student_mobile" class="col-md-3 col-form-label label-required">Mobile No.</label>
              <div class="col-md-9">
                <input type="text" id="student_mobile" class="form-control" placeholder="Mobile No." wire:model="student_mobile">
                @error('student_mobile')
                  <span class="text-danger">
                    {{ $message }}
                  </span>
                @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-sm btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Delete Modal -->
  <div class="modal fade" id="deleteStudentModal" tabindex="-1" role="dialog" aria-labelledby="deleteStudentModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Confirmation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="cancel()">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body pt-4 pb-4">
          <h5>Are you sure you want to delete this student information?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" wire:model="cancel()">Cancel</button>
          <button type="button" class="btn btn-sm btn-danger" wire:click="deleteStudentData">Delete</button>
        </div>
      </div>
    </div>
  </div>
  <!-- View Modal -->
  <div class="modal fade" id="viewStudentModal" tabindex="-1" role="dialog" aria-labelledby="viewStudentModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Student Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeViewStudentModal">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <ul class="list-group">
                <li class="list-group-item active">Personal Information</li>
                <li class="list-group-item"><strong>Student ID:</strong> {{ $view_student_id }}</li>
                <li class="list-group-item"><strong>Last Name:</strong> {{ $view_student_lname }}</li>
                <li class="list-group-item"><strong>First Name:</strong> {{ $view_student_fname }}</li>
                <li class="list-group-item"><strong>Middle Name:</strong> {{ $view_student_mname }}</li>
              </ul>
            </div>
            <div class="col-md-12 mt-3">
              <ul class="list-group">
                <li class="list-group-item active">Contact Information</li>
                <li class="list-group-item"><strong>Email Address:</strong> {{ $view_student_email }}</li>
                <li class="list-group-item"><strong>Mobile No.:</strong> {{ $view_student_mobile }}</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" wire:click="closeViewStudentModal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
  <script>
    /* window.addEventListener('close-modal', function(event){
      $("#addStudentModal").modal("hide");
    }); */

    $(document).ready(function(){
      $(document).on("close-modal", function(event){
        $("#addStudentModal").modal('hide');
        $("#editStudentModal").modal('hide');
        $("#deleteStudentModal").modal('hide');
      });

      $(document).on("show-edit-student-modal", function(event){
        $("#editStudentModal").modal('show');
      });

      $(document).on("show-delete-confirmation-modal", function(event){
        $("#deleteStudentModal").modal('show');
      });

      $(document).on("show-view-student-modal", function(event){
        $("#viewStudentModal").modal('show');
      });
    });
  </script>
@endpush