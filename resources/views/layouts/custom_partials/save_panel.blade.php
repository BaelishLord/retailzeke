
@if (Route::currentRouteName() != Request::segment(2).".show")
<section class="panel">
    <div class="panel-body">    
        <div class="btn-group">
            <button class="btn btn-success cbtn" name="save" value="save_return" type="submit" id="save_return">Save</button>
        </div>
        <div class="btn-group pull-right">
<<<<<<< HEAD
            <a href="/{{Request::segment(1)}}/"><button class="btn btn-danger" name="cancel" value="cancel" type="button" id="cancel">Cancel</button></a>
=======
            <a href="/{{Request::segment(1)}}"><button class="btn btn-danger" name="cancel" value="cancel" type="button" id="cancel">Cancel</button></a>
>>>>>>> d4a34547dd715297ea79a1827b0021dcdbf7aca1
        </div>
    </div>
</section>
@endif