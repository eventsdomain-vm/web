<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Project Teams</h2>
            <button onclick="document.getElementById('createTeamModal').classList.remove('hidden')" class="btn-primary text-sm">+ New Team</button>
        </div>
     <?php $__env->endSlot(); ?>
    <div class="container-page py-6 space-y-6">
        <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="space-y-4">
                <div class="flex items-center gap-2 px-2">
                    <h3 class="font-semibold text-lg text-gray-900"><?php echo e($event->name); ?></h3>
                    <span class="text-sm text-gray-500">(<?php echo e($event->eventTeams->count() ?? 0); ?> teams)</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php $__empty_2 = true; $__currentLoopData = $teams->where('event_id', $event->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                        <div class="card p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-semibold text-gray-900"><?php echo e($team->name); ?></h4>
                                <span class="text-xs text-gray-500"><?php echo e($team->members->count()); ?> members</span>
                            </div>
                            <?php if($team->lead): ?><p class="text-sm text-gray-500 mb-3">Lead: <?php echo e($team->lead->name); ?></p><?php endif; ?>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <?php $__currentLoopData = $team->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 rounded-full text-xs">
                                        <div>
                                            <div class="font-medium"><?php echo e($member->user->name); ?></div>
                                            <div class="text-gray-500 text-xs"><?php echo e($member->designation ?? 'N/A'); ?> (<?php echo e($member->role); ?>)</div>
                                        </div>
                                        <form method="POST" action="<?php echo e(route('sponsor.teams.members.destroy', [$team, $member])); ?>" style="display: inline;" onsubmit="return confirm('Remove this member?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-gray-400 hover:text-red-500 ml-1">&times;</button>
                                        </form>
                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <button onclick="document.getElementById('addMemberModal-<?php echo e($team->id); ?>').classList.remove('hidden')" class="btn-outline text-xs w-full">+ Add Member</button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                        <div class="card p-8 text-center text-gray-500 col-span-2">No teams created for this project yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card p-8 text-center text-gray-500">
                <p class="mb-2">No active projects/events yet.</p>
                <p class="text-sm">Create or request sponsorship for events to organize teams.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Create Team Modal -->
    <div id="createTeamModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-lg p-6 w-full max-w-md" onclick="event.stopPropagation()">
            <h3 class="font-semibold text-lg mb-4">Create Team for Project</h3>
            <form method="POST" action="<?php echo e(route('sponsor.teams.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Project/Event *</label>
                    <select name="event_id" required class="w-full border-gray-300 rounded-md">
                        <option value="">Select a project...</option>
                        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($event->id); ?>"><?php echo e($event->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Team Name *</label>
                    <input type="text" name="name" required class="w-full border-gray-300 rounded-md" placeholder="e.g., Marketing Team, Event Logistics">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" class="w-full border-gray-300 rounded-md" rows="2" placeholder="Optional team description"></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="this.closest('#createTeamModal').classList.add('hidden')" class="btn-outline">Cancel</button>
                    <button type="submit" class="btn-primary">Create Team</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Member Modals for each team -->
    <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div id="addMemberModal-<?php echo e($team->id); ?>" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="if(event.target===this)this.classList.add('hidden')">
            <div class="bg-white rounded-lg p-6 w-full max-w-md" onclick="event.stopPropagation()">
                <h3 class="font-semibold text-lg mb-4">Add Member to <?php echo e($team->name); ?></h3>
                <form method="POST" action="<?php echo e(route('sponsor.teams.members.store', $team)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Name *</label>
                        <input type="text" name="name" required class="w-full border-gray-300 rounded-md" placeholder="Full name">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Email ID *</label>
                        <input type="email" name="email" required class="w-full border-gray-300 rounded-md" placeholder="Email address">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Designation *</label>
                        <input type="text" name="designation" required class="w-full border-gray-300 rounded-md" placeholder="e.g., Project Manager, Coordinator">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Role *</label>
                        <select name="role" required class="w-full border-gray-300 rounded-md">
                            <option value="">Select a role...</option>
                            <option value="viewer">Viewer</option>
                            <option value="editor">Editor</option>
                            <option value="approver">Approver</option>
                            <option value="finance">Finance</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="this.closest('#addMemberModal-<?php echo e($team->id); ?>').classList.add('hidden')" class="btn-outline">Cancel</button>
                        <button type="submit" class="btn-primary">Add Member</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/sponsor/teams/index.blade.php ENDPATH**/ ?>