@extends('verification.layouts.header')
{{-- -------------- dynamic title ---------------- --}}
@section('title', 'Verification login')
{{-- ----------------- dynamic body content ------------------ --}}
@section('content')
    <!-- content -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mt-8 space-y-12 mb-12">
                <div class="mb-6 space-y-2 flex items-end justify-between">
                    <p class="text-3xl font-semibold">Profile Details</p>
                </div>
                @if($candidate->profile_verify_status == 0)
                <div class="bg-yellow-100 p-6 text-yellow-600 mb-24 rounded-3xl">
                    <div class="flex gap-4">
                        <i class="bi bi-exclamation-triangle mt-0.5"></i>
                        <div class="">
                            <p class="text-xl font-semibold mb-1">Verification Progress</p>
                            <p class="text-sm">This profile is currently under review and pending verification. Please confirm that all the provided details are accurate and complete. Carefully review all personal, employment, and contact information to ensure there are no discrepancies before approving the verification.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="gap-24">
                <!-- <div class="flex-shrink-0">
                    <img src="../../assets/img/profile.jpg" alt="" class="h-32 w-32 rounded-full object-cover object-center">
                </div> -->
                <div class="grid gap-6">
                    <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                        <div class="lg:col-span-3">
                            <p class="text-lg font-bold text-sky-700">Basic Information</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">First Name</label>
                            <p class="font-semibold">{{ $candidate->full_name}}</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Middle Name</label>
                            <p class="font-semibold"></p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Last Name</label>
                            <p class="font-semibold">Walters</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Gender</label>
                            <p class="font-semibold">Male</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Date of Birth</label>
                            <p class="font-semibold">13 Mar 1989</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Mother/Father's Name</label>
                            <p class="font-semibold">Stephan Walters</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Caste/Category</label>
                            <p class="font-semibold">General</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Phone</label>
                            <p class="font-semibold">+91 967 000 0063</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Alt. Phone</label>
                            <p class="font-semibold"></p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Email</label>
                            <p class="font-semibold">walters.rory217@gmail.com</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">PAN Number</label>
                            <p class="font-semibold">XXXXXXXXXXXXXXXX</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Disability Type</label>
                            <p class="font-semibold">XXXXXXXXXXXXXXXX</p>
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                        <div class="lg:col-span-3">
                            <p class="text-lg font-bold text-sky-700">Employment Information</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">District</label>
                            <p class="font-semibold">Kamrup Metro</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Department</label>
                            <p class="font-semibold">Health</p>
                        </div>
                        <!-- <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">DDO Code</label>
                            <p class="font-semibold">DIS001</p>
                        </div> -->
                        <div class="col-span-2">
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Office</label>
                            <p class="font-semibold">XXXXXXXXXXXXXXXX</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Designation</label>
                            <p class="font-semibold">Addl. Secretary</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Date of Joining <span class="text-gray-900">(First Joining)</span></label>
                            <p class="font-semibold">07 Dec 2002</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Date of Joining <span class="text-gray-900">(Current Posting)</span></label>
                            <p class="font-semibold">12 Aug 2006</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Pay Grade</label>
                            <p class="font-semibold">III</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Pay Band</label>
                            <p class="font-semibold">5500 - 6500</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Are you an ex-serviceman?</label>
                            <p class="font-semibold">XXXXXXXXXXXXXXXX</p>
                        </div>
                    </div>
                    <div class="grid gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                        <div class="">
                            <p class="text-lg font-bold text-sky-700">Preferences</p>
                        </div>
                        <div class="relative">
                            <span class="absolute -translate-y-1/2 font-black top-1/2 left-2.5 italic text-gray-900">1st</span>
                            <div class="block p-2.5 pl-16 w-full">
                                <p class="font-semibold">Nagaon</p>
                            </div>
                        </div>
                        <div class="relative">
                            <span class="absolute -translate-y-1/2 font-black top-1/2 left-2.5 italic text-gray-900">2nd</span>
                            <div class="block p-2.5 pl-16 w-full">
                                <p class="font-semibold">Cachar</p>
                            </div>
                        </div>
                        <div class="relative">
                            <span class="absolute -translate-y-1/2 font-black top-1/2 left-2.5 italic text-gray-900">3rd</span>
                            <div class="block p-2.5 pl-16 w-full">
                                <p class="font-semibold">Kamrup</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-3 gap-4 lg:gap-8 border border-sky-500 border-r-4 border-b-4 rounded-2xl p-10">
                        <div class="lg:col-span-3">
                            <p class="text-lg font-bold text-sky-700">Additional Information</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Are there any criminal cases pending?</label>
                            <p class="font-semibold">Yes / No</p>
                        </div>
                        <div class="">
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Have you availed any mutual transfer before?</label>
                            <p class="font-semibold">Yes / No</p>
                        </div>
                        <div class="">
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">How many mutual transfer?</label>
                            <p class="font-semibold">NA / 1 / 2</p>
                        </div>
                        <div class="">
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Any pending govt. dues?</label>
                            <p class="font-semibold">Yes / No</p>
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                        <div class="lg:col-span-3">
                            <p class="text-lg font-bold text-sky-700">Documents</p>
                        </div>
                        <a href="../../assets/img/profile.jpg" target="_blank" class="border rounded-xl bg-neutral-600">
                            <div class="h-44 p-2">
                                <img src="../../assets/img/profile.jpg" alt="" class="w-full h-full object-contain object-center">
                            </div>
                            <div class="text-white text-center p-2">Photo</div>
                        </a>
                        <a href="../../assets/img/sign.png" target="_blank" class="border rounded-xl bg-neutral-600">
                            <div class="h-44 p-2">
                                <img src="../../assets/img/sign.png" alt="" class="w-full h-full object-contain object-center">
                            </div>
                            <div class="text-white text-center p-2">Signature</div>
                        </a>
                        <a href="../../assets/img/aadhar.png" target="_blank" class="border rounded-xl bg-neutral-600">
                            <div class="h-44 p-2">
                                <img src="../../assets/img/aadhar.png" alt="" class="w-full h-full object-contain object-center">
                            </div>
                            <div class="text-white text-center p-2">PAN Card</div>
                        </a>
                        <a href="../../assets/img/emp_id.webp" target="_blank" class="border rounded-xl bg-neutral-600">
                            <div class="h-44 p-2">
                                <img src="../../assets/img/emp_id.webp" alt="" class="w-full h-full object-contain object-center">
                            </div>
                            <div class="text-white text-center p-2">Department ID Card</div>
                        </a>
                        <a href="../../assets/img/no_due.jpg" target="_blank" class="border rounded-xl bg-neutral-600">
                            <div class="h-44 p-2">
                                <img src="../../assets/img/no_due.jpg" alt="" class="w-full h-full object-contain object-center">
                            </div>
                            <div class="text-white text-center p-2">No Govt. Due Certificate</div>
                        </a>
                    </div>

                    {{--  --}}

                    
                    <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6 doc-section">
                        <div class="lg:col-span-3">
                            <div class="h-full flex items-end">
                                <p class="text-lg font-bold text-sky-700">Additional Documents</p>
                            <div class="ml-auto">
                                <button type="button" id="add-more" class="ml-auto bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-2 py-0.5"><i class="bi bi-plus-lg text-lg pr-1"></i>Add More</button>  
                            </div>
                            </div>
                        </div>
                        <div class="border rounded-xl bg-neutral-600 p-2 px-2.5 flex flex-col gap-2 doc-upload">
                            <div class="flex">
                                <p class="text-white text-center">Document Name</p>
                                <button class="ml-auto p-2 text-gray-300 hover:text-red-400 doc-close">
                                    <i class="bi bi-x-lg text-lg"></i>
                                </button>
                            </div>
                            <input type="file" name="remarks_docs[]" id="" class="border rounded-xl bg-neutral-600" value="">
                            <label class="block mb-0 text-xs md:text-sm font-bold text-white">Document For:</label>
                            <textarea name="remarks_text[]" class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full" rows="1" required></textarea>
                        </div>    
                    </div>



                    <!-- Verification and Noc status displayed after verified -->
                    <div class="grid lg:grid-cols-3 gap-4 border border-sky-500 rounded-3xl border-b-4 border-r-4 p-6">
                        <div class="lg:col-span-3">
                            <p class="text-lg font-bold text-sky-700">Verification & NOC Information</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Verified By</label>
                            <p class="font-semibold">XXXXXXXXXXXXXXXXXX</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">Verified On</label>
                            <p class="font-semibold">07 Dec 2002</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">NOC Generated</label>
                            <p class="font-semibold">Yes / No</p>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs md:text-sm font-black text-gray-900">NOC Generated</label>
                            <p class="font-semibold"><a href="../../assets/docs/NOC.pdf" class="hover:bg-gray-200 border border-transparent text-gray-600 hover:text-black rounded-md block px-2 py-1.5 duration-300 w-fit"><i class="bi bi-file-earmark-lock"></i></a></p>
                        </div>
                    </div>
                    <!-- Verification and Noc status displayed after verified end -->
                </div>
            </div>
            <div class="mt-12">
                <div class="flex items-center justify-end gap-1">
                    @if($candidate->profile_verify_status != 1)
                    <button type="button" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 directRequest">Verify</button>
                    <button type="button" class="bg-red-500 hover:bg-red-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 rejectRequestBtn">Reject</button>
                    {{-- <button type="button" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300" disabled>Generate NOC</button> --}}
                    @else
                        @if($user_role == 'Appointing Authority')
                            @if($candidate->noc_generate != 1)
                            <button type="button" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 directNOC">I recommend</button>
                            <button type="button" class="bg-red-500 hover:bg-red-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 rejectRequestBtn">I do not recommend</button>
                            @else
                            <button type="button" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300" disabled>I recommend</button>
                            <button type="button" class="bg-red-500 hover:bg-red-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 rejectRequestBtn">I do not recommend</button>
                            @endif
                        @elseif($user_role == 'Verifier')
                        <button type="button" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 directRequest">Verify</button>
                        <button type="button" class="bg-red-500 hover:bg-red-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 rejectRequestBtn">Reject</button>
                        @elseif($user_role == 'Approver')
                        <button type="button" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 directNOC">I recommend</button>
                        <button type="button" class="bg-red-500 hover:bg-red-600 border border-transparent text-white text-sm rounded-md block px-4 py-1.5 disabled:opacity-80 disabled:bg-sky-300 rejectRequestBtn">I do not recommend</button>
                        <a href="#" class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300">Next <i class="bi bi-arrow-right"></i></a>
                        @endif
                    @endif
                </div>
                <!-- modal -->
                <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]" id="directRequestModal">
                    <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
                        <div class="space-y-2 mb-6">
                            <p class="text-3xl font-semibold">Verify Profile</p>
                        </div>
                        <form action="/verifier/verify-candidates" method="post">
                            @csrf
                            <div class="grid gap-8">
                                <input type="hidden"  name="candidate_verify_id" value="{{$candidate->id}}">
                                <input type="hidden" name="add_docs" id="add_docs" value=""/>
                                <div class="flex gap-3">
                                    <input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5" required>
                                    <p class="text-xs text-gray-900">I have thoroughly verified the employee's profile, and I confirm that all provided details, including personal, employment, and contact information, are accurate to the best of my knowledge.</p>
                                </div>
                                <div class="flex gap-3">
                                    <input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5" required>
                                    <p class="text-xs text-gray-900">I confirm that the information provided by the employee matches the official records and no discrepancies were found during the verification process.</p>
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs md:text-sm font-bold text-gray-800">Remarks</label>
                                    <textarea name="verification_remarks" class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full" rows="4" ></textarea>
                                </div>
                                <div class="flex gap-1 justify-end">
                                    <button type="button" class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300" id="closeDirectRequestModalButton">Close</button>
                                    <button type="submit" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- reject modal -->
                <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]" id="rejectModal">
                    <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
                        <div class="space-y-2 mb-6">
                            <p class="text-3xl font-semibold">Reject Profile</p>
                        </div>
                        <form action="{{ url('verifier/reject-candidates')}}" method="post">
                            @csrf
                            <div class="grid gap-8">
                                <div>
                                    <input type="hidden" id="candidate_reject_id" name="candidate_reject_id" value="{{$candidate->id}}">
                                    <label class="block mb-1 text-xs md:text-sm font-bold text-gray-800">Rejection Reason</label>
                                    <textarea name="reject_message" class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full" rows="4" required></textarea>
                                </div>
                                <div class="flex gap-1 justify-end">
                                    <button type="button" class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300" id="closeRejectModalButton">Close</button>
                                    <button type="submit" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- NOC modal -->
                <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]" id="directNOCModal">
                    <div class="max-w-md w-full bg-white rounded-2xl p-6 py-10">
                        <div class="space-y-2 mb-6">
                            <p class="text-3xl font-semibold">Generate NOC</p>
                        </div>
                        <form action="{{ url('verifier/noc-update')}}" method="post">
                            @csrf
                            <div class="grid gap-8">
                                <div class="">
                                    <div class="flex gap-3">
                                        <input type="hidden" name="direct_noc_id" id="direct_noc_id" value="{{$candidate->id}}"/>
                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5" required>
                                        <p class="text-xs text-gray-900">I confirm that all profiles have been successfully generated and are ready for review.</p>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="flex gap-3">
                                        <input type="checkbox" class=" border border-gray-300 text-sky-600 text-sm rounded-md focus:ring-sky-600 focus:border-sky-600 block p-1.5 mt-0.5" required>
                                        <p class="text-xs text-gray-900">I acknowledge that all required documents are in order and approve the NOC generation.</p>
                                    </div>
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs md:text-sm font-bold text-gray-800">Remarks</label>
                                    <textarea name="verification_remarks" class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full" rows="4" ></textarea>
                                </div>
                                <div class="flex gap-1 justify-end">
                                    <button type="button" class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300" id="closeDirectNOCModalButton">Close</button>
                                    <button type="submit" class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">I recommend</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- footer -->

    
 @endsection
 {{-- --------------------- dynamic js link ------------------ --}}
 @section('extra_js')
 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
     <script type="module" src="{{ asset('js/verification/login.js') }}"></script>
     @if (session('flash_message'))
     <script>
         $(document).ready(function() {
             var count = {{ session('flash_message') }};
             var message = "{{ session('message') }}";
             console.log(message)
             if(count == 1){
                 showSuccessPopup(message);
             }
             if(count == 2){
                 console.log('error')
                 showErrorPopup(message);
             }
             setTimeout(function() {
                 hidePopup()
             }, 1550); 
         });
     </script>
 @endif
 
  <script>
     function showSuccessPopup(message = null) {
     $('.popup').removeClass('hidden');      
     $('.popup-success').removeClass('hidden');  
     $('.popup-error').addClass('hidden');
     $('.popup-success .text-gray-900').text(message);      
     }
     // Function to show the error popup
     function showErrorPopup(message = null) {
     $('.popup').removeClass('hidden');        
     $('.popup-error').removeClass('hidden');   
     $('.popup-success').addClass('hidden');
     $('.error-msg').text(message);     
     }
     // Function to hide the popup
     function hidePopup() {
     $('.popup').addClass('hidden');            
     $('.popup-success').addClass('hidden');    
     $('.popup-error').addClass('hidden');      
     }
  </script>

     <script>
         $(document).ready(function(argument) {
             $('#createRequest').on('click', function() {
                 if ($('#requestModal').hasClass('hidden')) {
                     $('#requestModal').removeClass('hidden');
                 }
             });
             $('#closeModalButton').on('click', function() {
                 $('#requestModal').addClass('hidden');
             });


             $('.directRequest').on('click', function() {
                 if ($('#directRequestModal').hasClass('hidden')) {
                     $('#directRequestModal').removeClass('hidden');
                     $('body').css('overflow', 'hidden');
                 }
                 var data = [];
                    $('.doc-upload').each(function() {
                        var fileInput = $(this).find('input[type="file"]').val(); 
                        var textarea = $(this).find('textarea').val();
                        if(fileInput == ''){
                            return data;
                        }
                        data.push({
                            file: fileInput,
                            text: textarea
                        });
                    });
                $('#add_docs').val(data);
             });


             $('#closeDirectRequestModalButton').on('click', function() {
                 $('#directRequestModal').addClass('hidden');
                 $('body').css('overflow', 'visible');
                 $('#add_docs').val('');
             });
             $('.rejectRequestBtn').on('click', function() {
             if ($('#rejectModal').hasClass('hidden')) {
                 $('#rejectModal').removeClass('hidden');
                 $('body').css('overflow', 'hidden');
             }   
             });
             $('#closeRejectModalButton').on('click', function() {
                 $('#rejectModal').addClass('hidden');
                 $('body').css('overflow', 'visible');
             });
             $('.directNOC').on('click', function() {
                if ($('#directNOCModal').hasClass('hidden')) {
                    $('#directNOCModal').removeClass('hidden');
                    $('body').css('overflow', 'hidden');
                }
            });
            $('#closeDirectNOCModalButton').on('click', function() {
                $('#directNOCModal').addClass('hidden');
                $('body').css('overflow', 'visible');
            });


            $('#add-more').click(function(){
                var content = `<div class="border rounded-xl bg-neutral-600 p-2 px-2.5 flex flex-col gap-2 doc-upload">
                            <div class="flex">
                                <p class="text-white text-center">Document Name</p>
                                <button class="ml-auto p-2 text-gray-300 hover:text-red-400 doc-close">
                                    <i class="bi bi-x-lg text-lg"></i>
                                </button>
                            </div>

                             <input type="file" name="" id="" class="border rounded-xl bg-neutral-600" value="">
                            <label class="block mb-0 text-xs md:text-sm font-bold text-white">Document For:</label>
                            <textarea name="reject_message" class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full" rows="1" required></textarea>
                        </div>`;
                $('.doc-section').append(content);
            });

            $(document).on('click', '.doc-close', function () {
                var $docSection = $(this).closest('.doc-section'); 
                var $docUpload = $(this).closest('.doc-upload');  

                if ($docSection.find('.doc-upload').length === 1) {
                    alert("This is the last document upload section!");
                } else {
                    $docUpload.remove();
                }
            });

             // Document
            $(document).on('click', '.up_doc_rmv_btn', function() {
            var up_prev_rmv = $(this);
            up_prev_rmv.closest('.up_doc_prev_con').addClass('hidden');
            up_prev_rmv.closest('.up_doc_con').find('.up_input').val(''); 
            });

        $(document).on('change', '.up_input', function() {
            var up_prev = $(this);
            var up_prev_name = $(this)[0].files[0];

            // Check if a file is selected
            if (up_prev.val() != null && up_prev.val() != "") {
                up_prev.closest('.up_doc_con').find('.up_doc_prev_con').removeClass('hidden');
            } else {
                up_prev.closest('.up_doc_con').find('.up_doc_prev_con').addClass('hidden');
            }

            // If a file is selected, update the specific file name field
            if (up_prev_name) {
                var fileName = up_prev_name.name;
                up_prev.closest('.up_doc_con').find('.up_doc_name').html(fileName); // Target the correct .up_doc_name element
            }
        });
         });
         </script>


 @endsection

</body>

</html>
