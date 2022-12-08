<div class="d-flex flex-wrap gap-2 justify-content-between mb-8">
    this is overview                     
</div>
<!--end::Title-->

<!--end::Message accordion-->
<div class="separator my-6"></div>
<!--begin::Message accordion-->

<!--begin::Form-->
<form id="kt_inbox_reply_form" class="rounded border mt-10">
    <!--begin::Body-->
    <div class="d-block">  
        <!--begin::Message-->
        <textarea 
            class="form-control" 
            name="visit_note"  
            cols="30" 
            rows="10"
        >{{ $visit->visit_note }}</textarea>
        <!--end::Message-->                                
    </div>
    <!--end::Body-->

    <!--begin::Footer-->
    <div class="d-flex flex-stack flex-wrap gap-2 py-5 ps-8 pe-5 border-top">
        <!--begin::Actions-->
        <div class="d-flex align-items-center me-3">
            <!--begin::Send-->
            <div class="btn-group me-4">
                <!--begin::Submit-->
                <button type="submit" class="btn btn-primary">Approve</button>
                <!--end::Submit-->                                       
            </div>
            <!--end::Send-->                                     
        </div>
        <!--end::Actions-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">                                       
            <!--begin::Dismiss reply-->
            <span class="btn btn-icon btn-sm btn-clean btn-active-light-primary" data-inbox="dismiss" data-toggle="tooltip" title="Dismiss reply">
                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </span>
            <!--end::Dismiss reply-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Footer-->

</form>
<!--end::Form-->