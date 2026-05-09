@php
    $modalid = !empty($id) ? "modal-{$id}" : "modal";
@endphp
<div class="modal fade" id="{{$modalid}}" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-{{$size ?? "lg"}}">
        <form class="modal-content" onsubmit="return false;">
            {!! $slot ?? "" !!}
        </form>
    </div>
</div>

<script>
    let {{str_replace("-", "_", $modalid)}};
    
    document.addEventListener("DOMContentLoaded", function() {
        {{str_replace("-", "_", $modalid)}} = new bootstrap.Modal(document.getElementById('{{$modalid}}'));
        
        @if (!empty($id) && !isset($stoppropagation))
            {{str_replace("-", "_", $modalid)}}._element.addEventListener('hide.bs.modal', event => {
                modal.show();
            });
        @endif
        
        {{str_replace("-", "_", $modalid)}}._element.addEventListener('hidden.bs.modal', event => {
            {{str_replace("-", "_", $modalid)}}._element.querySelector(".modal-dialog").setAttribute("class", "modal-dialog modal-{{$size ?? 'lg'}}");
        });
    });
</script>