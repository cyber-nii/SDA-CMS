<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Register New Member') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen" x-data="formWizard()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stepper UI -->
            <div class="mb-8 px-4 sm:px-0" x-cloak>
                <div class="flex items-center justify-between relative max-w-2xl mx-auto">
                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 z-0 rounded"></div>
                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-primary-600 z-0 transition-all duration-500 ease-in-out rounded" :style="'width: ' + ((step - 1) * 50) + '%'"></div>
                    
                    <!-- Step 1 -->
                    <div class="relative z-10 flex flex-col items-center">
                        <button type="button" @click="if(step > 1) step = 1" class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm border-4 border-gray-50 transition-colors duration-300 shadow-sm focus:outline-none"
                             :class="step >= 1 ? 'bg-primary-600 text-white' : 'bg-white text-gray-400 border-gray-200'">1</button>
                        <span class="mt-2 text-xs font-bold uppercase tracking-wider transition-colors duration-300" :class="step >= 1 ? 'text-primary-700' : 'text-gray-400'">Personal</span>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="relative z-10 flex flex-col items-center">
                        <button type="button" @click="if(step > 2) step = 2" class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm border-4 border-gray-50 transition-colors duration-300 shadow-sm focus:outline-none"
                             :class="step >= 2 ? 'bg-primary-600 text-white' : 'bg-white text-gray-400 border-gray-200'">2</button>
                        <span class="mt-2 text-xs font-bold uppercase tracking-wider transition-colors duration-300" :class="step >= 2 ? 'text-primary-700' : 'text-gray-400'">Church Info</span>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm border-4 border-gray-50 transition-colors duration-300 shadow-sm"
                             :class="step >= 3 ? 'bg-primary-600 text-white' : 'bg-white text-gray-400 border-gray-200'">3</div>
                        <span class="mt-2 text-xs font-bold uppercase tracking-wider transition-colors duration-300" :class="step >= 3 ? 'text-primary-700' : 'text-gray-400'">Access</span>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-2xl border border-gray-100 p-8 relative">

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative shadow-sm" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                                <ul class="list-disc pl-5 mt-2 text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('members.store') }}" enctype="multipart/form-data" id="registrationForm">
                    @csrf

                    <!-- STEP 1: Personal Details -->
                    <div id="step1" x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0" style="display: none;">
                        <div class="mb-6 pb-2 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-gray-800">Personal Details</h3>
                            <p class="text-sm text-gray-500 mt-1">Basic identification and contact information.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Profile Picture -->
                            <div class="md:col-span-2 flex items-center space-x-4 mb-2 bg-gray-50 p-5 rounded-xl border border-gray-100 shadow-sm">
                                <div id="image-preview"
                                    class="w-20 aspect-[3/4] rounded-lg bg-white flex items-center justify-center overflow-hidden border-2 border-dashed border-gray-300 shadow-sm transition-colors">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <label for="profile_picture" class="block font-bold text-sm text-gray-800 mb-1">Member Profile Picture</label>
                                    <input id="profile_picture" type="file" name="profile_picture" accept="image/jpeg, image/png, image/webp"
                                        onchange="previewImage(event)"
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 cursor-pointer file:cursor-pointer file:transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 rounded-lg" />
                                    <p class="text-xs text-gray-500 mt-2">Recommended: Portrait image (3:4 ratio), max 2MB (JPG, PNG).</p>
                                </div>
                            </div>

                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="block font-semibold text-sm text-gray-700">First Name <span class="text-red-500">*</span></label>
                                <input id="first_name" class="block mt-1 w-full rounded-lg shadow-sm border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-colors bg-gray-50 focus:bg-white" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus placeholder="John" />
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block font-semibold text-sm text-gray-700">Last Name <span class="text-red-500">*</span></label>
                                <input id="last_name" class="block mt-1 w-full rounded-lg shadow-sm border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-colors bg-gray-50 focus:bg-white" type="text" name="last_name" value="{{ old('last_name') }}" required placeholder="Doe" />
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label for="date_of_birth" class="block font-semibold text-sm text-gray-700">Date of Birth</label>
                                <input id="date_of_birth" class="block mt-1 w-full rounded-lg shadow-sm border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-colors bg-gray-50 focus:bg-white text-gray-700" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" />
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block font-semibold text-sm text-gray-700">Gender <span class="text-red-500">*</span></label>
                                <select id="gender" name="gender" class="block mt-1 w-full rounded-lg shadow-sm border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-colors bg-gray-50 focus:bg-white" required>
                                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block font-semibold text-sm text-gray-700">Email Address <span class="text-red-500">*</span></label>
                                <input id="email" class="block mt-1 w-full rounded-lg shadow-sm border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-colors bg-gray-50 focus:bg-white" type="email" name="email" value="{{ old('email') }}" required placeholder="john.doe@example.com" />
                                <p class="text-xs text-gray-500 mt-1 flex items-center"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>Required for login account creation.</p>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="contact_number" class="block font-semibold text-sm text-gray-700">Phone Number</label>
                                <input id="contact_number" class="block mt-1 w-full rounded-lg shadow-sm border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-colors bg-gray-50 focus:bg-white" type="text" name="contact_number" value="{{ old('contact_number') }}" placeholder="+1 (555) 000-0000" />
                            </div>
                            
                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address" class="block font-semibold text-sm text-gray-700">Home Address</label>
                                <textarea id="address" class="block mt-1 w-full rounded-lg shadow-sm border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-colors bg-gray-50 focus:bg-white" name="address" rows="2" placeholder="123 Church St, City, State, ZIP">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100 gap-4">
                            <a href="{{ route('members.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all">Cancel</a>
                            <button type="button" @click="nextStep(1)" class="px-6 py-2.5 bg-primary-600 border border-transparent rounded-lg font-bold text-sm text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all active:scale-95 flex items-center gap-2">
                                Next Step
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: Church Information -->
                    <div id="step2" x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0" style="display: none;">
                        <div class="mb-6 pb-2 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-gray-800">Church Information</h3>
                            <p class="text-sm text-gray-500 mt-1">Membership status and ministry assignments.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Membership Status -->
                            <div>
                                <label for="status" class="block font-semibold text-sm text-gray-700">Status <span class="text-red-500">*</span></label>
                                <select id="status" name="status" class="block mt-1 w-full rounded-lg shadow-sm border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-colors bg-gray-50 focus:bg-white" required>
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="Transferred" {{ old('status') == 'Transferred' ? 'selected' : '' }}>Transferred</option>
                                    <option value="Deceased" {{ old('status') == 'Deceased' ? 'selected' : '' }}>Deceased</option>
                                </select>
                            </div>

                            <!-- Baptism Date -->
                            <div>
                                <label for="baptism_date" class="block font-semibold text-sm text-gray-700">Baptism Date</label>
                                <input id="baptism_date" class="block mt-1 w-full rounded-lg shadow-sm border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-colors bg-gray-50 focus:bg-white text-gray-700" type="date" name="baptism_date" value="{{ old('baptism_date') }}" />
                            </div>

                            <!-- Departments -->
                            <div class="md:col-span-2 mt-2">
                                <label for="departments" class="block font-semibold text-sm text-gray-700">Assign to Departments / Ministries</label>
                                <p class="text-xs text-gray-500 mb-2">Hold Ctrl (Windows) or Cmd (Mac) to select multiple ministries.</p>
                                <select id="departments" name="departments[]" class="block w-full rounded-lg shadow-sm border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-colors bg-gray-50 focus:bg-white" multiple size="6">
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->department_id }}" {{ (collect(old('departments'))->contains($dept->department_id)) ? 'selected' : '' }} class="p-2 hover:bg-primary-50 cursor-pointer rounded-md mx-1 my-0.5">
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
                            <button type="button" @click="step = 1; window.scrollTo({ top: 0, behavior: 'smooth' });" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                Back
                            </button>
                            <button type="button" @click="nextStep(2)" class="px-6 py-2.5 bg-primary-600 border border-transparent rounded-lg font-bold text-sm text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all active:scale-95 flex items-center gap-2">
                                Next Step
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: System Access -->
                    <div id="step3" x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0" style="display: none;">
                        <div class="mb-6 pb-2 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-gray-800">System Access</h3>
                            <p class="text-sm text-gray-500 mt-1">Configure account permissions and generation.</p>
                        </div>
                        
                        <div class="bg-primary-50 border border-primary-100 rounded-xl p-5 mb-6 flex items-start gap-4">
                            <div class="bg-primary-100 p-2 rounded-full text-primary-700 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-primary-800 text-sm">Account Generation Setup</h4>
                                <p class="text-sm text-primary-700 mt-1">An account will be automatically generated using the member's email address provided in Step 1. Please save the default password displayed below to share securely with the member.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Role Selection -->
                            <div>
                                <label for="role" class="block font-semibold text-sm text-gray-700">System Role <span class="text-red-500">*</span></label>
                                <select id="role" name="role" class="block mt-1 w-full rounded-lg shadow-sm border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition-colors bg-gray-50 focus:bg-white" required>
                                    @foreach($roles as $roleOption)
                                        <option value="{{ $roleOption }}" {{ old('role', 'Member') == $roleOption ? 'selected' : '' }}>
                                            {{ $roleOption }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1 flex items-center"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Select the permission level for this user.</p>
                            </div>

                            <!-- Default Password -->
                            <div>
                                <label for="default_password" class="block font-semibold text-sm text-gray-700">Default Password (Read Only)</label>
                                <div class="relative mt-1 rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <input id="default_password" class="block w-full pl-10 rounded-lg shadow-sm border-gray-300 bg-gray-100 text-gray-800 font-mono font-bold tracking-wider focus:ring-0 cursor-not-allowed" type="text" name="default_password" value="{{ $defaultPassword }}" readonly />
                                </div>
                                <p class="text-xs text-primary-600 mt-1 font-medium">Member will be forced to change this on their first login.</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
                            <button type="button" @click="step = 2; window.scrollTo({ top: 0, behavior: 'smooth' });" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                Back
                            </button>
                            <button type="submit" class="px-8 py-2.5 bg-green-600 border border-transparent rounded-lg font-bold text-sm text-green-500 shadow-md shadow-green-500/30 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all active:scale-95 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Complete Registration
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function formWizard() {
            return {
                step: 1,
                init() {
                    // Check if there are errors and which step they might belong to
                    @if ($errors->any())
                        // Simple logic: if email or first_name error, stay on step 1
                        // else if status error, go to step 2, etc. (Default to step 1 is safest)
                        this.step = 1;
                    @endif
                },
                nextStep(current) {
                    let isValid = true;
                    const stepEl = document.getElementById('step' + current);
                    
                    // Force HTML5 validation UI for required fields in the current step
                    const inputs = stepEl.querySelectorAll('input[required], select[required]');
                    for (let input of inputs) {
                        if (!input.checkValidity()) {
                            input.reportValidity();
                            isValid = false;
                            break; // Stop at first invalid input
                        }
                    }

                    if (isValid) {
                        this.step = current + 1;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                }
            }
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('image-preview');
                output.innerHTML = `<img src="${reader.result}" class="w-full h-full object-cover">`;
                output.classList.remove('border-dashed', 'bg-white');
                output.classList.add('border-solid', 'border-primary-100', 'p-1', 'bg-gray-50');
            }
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</x-app-layout>