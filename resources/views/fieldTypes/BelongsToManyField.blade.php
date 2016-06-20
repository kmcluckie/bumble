<div class="control g-row" style="align-items: flex-start;">
    <div class="g-col-2 tar">
        {!! BumbleForm::label($field->getColumn(), $field->getRelatedTitle(), ['class' => 'label label--tar'.$model->getRequiredClass($field), 'style' => 'line-height: 4.4rem']) !!}
    </div>
     <div class="g-col-10">
        <?php
            $values = [];

            if ( ! $model->fieldIsRequired($field)) $values[0] = '--';

            $options = $model->{$field->method()}()->getRelated()->lists($field->getRelatedTitleColumn(), 'id');

            foreach ($options as $key => $value)
            {
                $values[$key] = $value;
            }
        ?>

        @if (isset($post))
            <div style="display: flex;">
                {!! BumbleForm::select($field->getColumn().'-list', $values, null, ['class' => 'input input1', 'placeholder' => $field->getPlaceholder(), 'style' => 'margin-right: 1rem;']) !!}
                {!! BumbleForm::button('Add', ['class' => 'btn form__btn--auto-with add-'.$field->getColumn(), 'type' => 'button', 'style' => 'padding: 0 2.5rem;']) !!}
            </div>

            <table class="table inline-table">
              <tbody class="{!! $field->getColumn() !!}-container">
                @foreach($post->{$field->method()}()->get() as $item)
                  <tr data-{!! $field->getColumn() !!}-id="{!! $item->id !!}">
                    <td>
                      {!! $item->{$field->getRelatedTitleColumn()} !!}
                      <input type="hidden" name="{!! $field->getColumn() !!}[]" value="{!! $item->id !!}">
                    </td>
                    <td>
                      <div class="inline-flex">
                        <button type="button" class="delete-post delete-{!! $field->getColumn() !!}"></button>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
        @else
          <div class="label" style="line-height: 4.4rem;">Please save this {!! $model->getModelName() !!} before adding {!! $field->getRelatedTitle() !!}.</div>
        @endif
    </div>
</div>

<script>
  $(function() {
    $('body').on('click', 'button.add-{!! $field->getColumn() !!}', function() {
      var option = $('select[name={!! $field->getColumn() !!}-list]').find(":selected");
      if (option.val() > 0 && $('div[data-{!! $field->getColumn() !!}-id='+option.val()+']').length == 0)
      {
        var new_item = '<tr data-{!! $field->getColumn() !!}-id="'+option.val()+'"><td>'+option.text()+'<input type="hidden" name="{!! $field->getColumn() !!}[]" value="'+option.val()+'"></td><td><div class="inline-flex"><button type="button" class="delete-post"></button></div></td></tr>';

        $('.{!! $field->getColumn() !!}-container').append(new_item);
      }
    });

    $('body').on('click', 'button.delete-{!! $field->getColumn() !!}', function() {
      $(this).closest('tr').remove();
    });
  });
</script>