<header class="slidePanel-header">
    <div class="overlay-top overlay-panel overlay-background bg-light-green-600">
        <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
            <button type="button" class="btn btn-pure slidePanel-close icon md-close" aria-hidden="true"></button>
        </div>
        <h4 class="stage-name">{{ $program->name }}</h4>
    </div>
</header>
<div class="slidePanel-inner">
    <section class="slidePanel-inner-section">
        {{ $program->description }}
    </section>
</div>