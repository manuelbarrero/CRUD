<!-- browse server input -->
  <div class="form-group">
    <label>{{ $field['label'] }}</label>
	<input
		type="text"
		class="form-control"
		id="{{ $field['name'] }}-filemanager"

		@foreach ($field as $attribute => $value)
			@if (is_string($attribute) && is_string($value))
			{{ $attribute }}="{{ $value }}"
			@endif
		@endforeach
		@if(!isset($field['readonly']) || $field['readonly']) readonly @endif
	>

	<div class="btn-group" role="group" aria-label="..." style="margin-top: 3px;">
	  <button type="button" data-inputid="{{ $field['name'] }}-filemanager" class="btn btn-default popup_selector">
		<i class="fa fa-cloud-upload"></i> Browse uploads</button>
		<button type="button" data-inputid="{{ $field['name'] }}-filemanager" class="btn btn-default clear_elfinder_picker">
		<i class="fa fa-eraser"></i> Clear</button>
	</div>

	@if (isset($field['hint']))
        <p class="help-block">{{ $field['hint'] }}</p>
    @endif

  </div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

	{{-- FIELD CSS - will be loaded in the after_styles section --}}
	@push('crud_fields_styles')
		<!-- include browse server css -->
		<link href="{{ asset('vendor/backpack/colorbox/example2/colorbox.css') }}" rel="stylesheet" type="text/css" />
	@endpush

	@push('crud_fields_scripts')
		<!-- include browse server js -->
		<script src="{{ asset('vendor/backpack/colorbox/jquery.colorbox-min.js') }}"></script>
	@endpush

@endif

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
	<script>
		$(document).on('click','.popup_selector[data-inputid={{ $field['name'] }}-filemanager]',function (event) {
		    event.preventDefault();

		    // trigger the reveal modal with elfinder inside
		    var triggerUrl = "{{ url(config('elfinder.route.prefix').'/popup/'.$field['name']."-filemanager") }}";
		    $.colorbox({
		        href: triggerUrl,
		        fastIframe: true,
		        iframe: true,
		        width: '70%',
		        height: '50%'
		    });
		});

		// function to update the file selected by elfinder
		function processSelectedFile(filePath, requestingField) {
		    $('#' + requestingField).val(filePath);
		}

		$(document).on('click','.clear_elfinder_picker[data-inputid={{ $field['name'] }}-filemanager]',function (event) {
		    event.preventDefault();
		    var updateID = $(this).attr('data-inputid'); // Btn id clicked
		    $("#"+updateID).val("");
		});
	</script>
@endpush

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}