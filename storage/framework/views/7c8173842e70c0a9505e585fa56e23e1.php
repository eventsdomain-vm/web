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
     <?php $__env->slot('title', null, []); ?> Social Posts - EventsDomain <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-gradient-to-r from-terracotta-500 to-orange-500 p-2.5 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Social Posts</h1>
                        <p class="text-sm text-gray-500">Manage and track your social media posts.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="<?php echo e(route($rp . '.dashboard')); ?>" class="text-sm text-gray-500 hover:text-gray-700 transition">
                        ← Back to Dashboard
                    </a>
                    <button onclick="openAICreateModal()" class="btn-primary inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create with AI
                    </button>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-emerald-700 text-sm font-medium">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <?php if($posts->count()): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 bg-gray-50/50">
                                    <th class="text-left px-6 py-3 font-semibold text-gray-600">Event</th>
                                    <th class="text-left px-6 py-3 font-semibold text-gray-600">Platforms</th>
                                    <th class="text-left px-6 py-3 font-semibold text-gray-600">Status</th>
                                    <th class="text-left px-6 py-3 font-semibold text-gray-600">Scheduled</th>
                                    <th class="text-left px-6 py-3 font-semibold text-gray-600">Created</th>
                                    <th class="text-right px-6 py-3 font-semibold text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50/50 transition cursor-pointer" onclick="window.location='<?php echo e(route($rp . '.posts.show', $post)); ?>'">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <?php if($post->event->cover_image): ?>
                                                    <img src="<?php echo e($post->event->cover_image); ?>" alt="" class="w-10 h-10 rounded-lg object-cover">
                                                <?php else: ?>
                                                    <div class="w-10 h-10 rounded-lg bg-terracotta-100 flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-terracotta-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="min-w-0">
                                                    <p class="font-medium text-gray-900 truncate"><?php echo e($post->event->title ?? 'Deleted Event'); ?></p>
                                                    <p class="text-xs text-gray-400 truncate">Post #<?php echo e($post->id); ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                <?php $__currentLoopData = $post->platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $colors = [
                                                            'facebook' => ['#1877F2', 'bg-blue-100 text-blue-700'],
                                                            'linkedin' => ['#0A66C2', 'bg-sky-100 text-sky-700'],
                                                            'instagram' => ['#E4405F', 'bg-pink-100 text-pink-700'],
                                                            'youtube' => ['#FF0000', 'bg-red-100 text-red-700'],
                                                        ];
                                                        [$color, $badgeClass] = $colors[$platform] ?? ['#6B7280', 'bg-gray-100 text-gray-700'];
                                                    ?>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium <?php echo e($badgeClass); ?>">
                                                        <?php echo e(ucfirst($platform)); ?>

                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php
                                                $statusStyles = [
                                                    'draft' => 'bg-gray-100 text-gray-700',
                                                    'scheduled' => 'bg-blue-100 text-blue-700',
                                                    'publishing' => 'bg-yellow-100 text-yellow-700',
                                                    'published' => 'bg-emerald-100 text-emerald-700',
                                                    'partial' => 'bg-orange-100 text-orange-700',
                                                    'failed' => 'bg-red-100 text-red-700',
                                                ];
                                            ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($statusStyles[$post->status] ?? 'bg-gray-100 text-gray-700'); ?>">
                                                <?php echo e($post->status_label); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500">
                                            <?php echo e($post->scheduled_at ? $post->scheduled_at->format('M d, Y g:i A') : '—'); ?>

                                        </td>
                                        <td class="px-6 py-4 text-gray-500">
                                            <?php echo e($post->created_at->format('M d, Y')); ?>

                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="<?php echo e(route($rp . '.posts.show', $post)); ?>" class="text-terracotta-500 hover:text-terracotta-600 font-medium text-sm">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    
                    <?php if($posts->hasPages()): ?>
                        <div class="px-6 py-4 border-t border-gray-100">
                            <?php echo e($posts->links()); ?>

                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    
                    <div class="text-center py-16">
                        <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">No social posts yet</h3>
                        <p class="text-sm text-gray-500 max-w-sm mx-auto">
                            Create your first social post from an event page to start sharing across platforms.
                        </p>
                        <a href="<?php echo e(route($rp . '.dashboard')); ?>" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-terracotta-500 text-white text-sm font-medium rounded-lg hover:bg-terracotta-600 transition">
                            Go to Dashboard
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div id="aiCreateModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40" onclick="closeAICreateModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900">Create Post with AI</h2>
                        <button onclick="closeAICreateModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                <form id="aiCreateForm" class="p-6 space-y-4" onsubmit="submitAICreate(event)">
                    <input type="hidden" name="event_id" id="ai_event_id" value="<?php echo e($posts->first()?->event_id ?? ''); ?>">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Topic / Headline *</label>
                        <input type="text" name="topic" id="ai_topic" required
                               placeholder="e.g. Launching our new AI-powered event platform"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-terracotta-500 focus:border-terracotta-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Key Points (optional)</label>
                        <input type="text" name="key_points_input" id="ai_key_points"
                               placeholder="Comma-separated, e.g. free tier, 10x faster, mobile app"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-terracotta-500 focus:border-terracotta-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Audience</label>
                            <input type="text" name="target_audience" id="ai_audience"
                                   placeholder="e.g. Event organizers"
                                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-terracotta-500 focus:border-terracotta-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tone</label>
                            <select name="tone" id="ai_tone"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-terracotta-500 focus:border-terracotta-500">
                                <option value="professional">Professional</option>
                                <option value="casual">Casual</option>
                                <option value="enthusiastic">Enthusiastic</option>
                                <option value="inspirational">Inspirational</option>
                                <option value="educational">Educational</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Call to Action</label>
                        <input type="text" name="cta" id="ai_cta"
                               placeholder="e.g. Register now for early bird pricing"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-terracotta-500 focus:border-terracotta-500">
                    </div>

                    
                    <div id="aiPreviewBox" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preview</label>
                        <div id="aiPreview" class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-700 whitespace-pre-wrap max-h-60 overflow-y-auto"></div>
                    </div>

                    <div id="aiError" class="hidden bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3"></div>
                    <div id="aiLoading" class="hidden text-center text-sm text-gray-500 py-4">
                        <svg class="animate-spin h-5 w-5 mx-auto text-terracotta-500 mb-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        Generating content...
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="button" onclick="generateAIPost()" id="btnGenerate"
                                class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">
                            Generate
                        </button>
                        <button type="submit" id="btnSchedule" disabled
                                class="px-4 py-2 bg-terracotta-500 text-white text-sm font-medium rounded-lg hover:bg-terracotta-600 disabled:opacity-40 disabled:cursor-not-allowed transition">
                            Schedule Post
                        </button>
                        <button type="button" onclick="closeAICreateModal()" class="ml-auto text-sm text-gray-500 hover:text-gray-700">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let generatedContent = '';

        function openAICreateModal() {
            document.getElementById('aiCreateModal').classList.remove('hidden');
            document.getElementById('aiCreateForm').reset();
            document.getElementById('aiPreviewBox').classList.add('hidden');
            document.getElementById('aiError').classList.add('hidden');
            document.getElementById('aiLoading').classList.add('hidden');
            document.getElementById('btnGenerate').disabled = false;
            document.getElementById('btnSchedule').disabled = true;
            generatedContent = '';
        }

        function closeAICreateModal() {
            document.getElementById('aiCreateModal').classList.add('hidden');
        }

        async function generateAIPost() {
            const eventId = document.getElementById('ai_event_id').value;
            if (!eventId) { alert('No event selected. Please create a post from an event page first.'); return; }

            const topic = document.getElementById('ai_topic').value.trim();
            if (!topic) { alert('Please enter a topic.'); return; }

            const keyPointsRaw = document.getElementById('ai_key_points').value.trim();
            const keyPoints = keyPointsRaw ? keyPointsRaw.split(',').map(s => s.trim()).filter(Boolean) : [];

            document.getElementById('aiLoading').classList.remove('hidden');
            document.getElementById('aiError').classList.add('hidden');
            document.getElementById('aiPreviewBox').classList.add('hidden');
            document.getElementById('btnGenerate').disabled = true;

            try {
                const resp = await fetch(`/organizer/events/${eventId}/posts/ai/generate`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                    body: JSON.stringify({
                        topic,
                        key_points: keyPoints,
                        target_audience: document.getElementById('ai_audience').value || null,
                        tone: document.getElementById('ai_tone').value,
                        cta: document.getElementById('ai_cta').value || null,
                    })
                });

                const data = await resp.json();

                if (resp.ok && data.success) {
                    generatedContent = data.content;
                    const hashtags = (data.hashtags || []).map(h => h.startsWith('#') ? h : '#' + h).join(' ');
                    document.getElementById('aiPreview').textContent = data.content + (hashtags ? '\n\n' + hashtags : '');
                    document.getElementById('aiPreviewBox').classList.remove('hidden');
                    document.getElementById('btnSchedule').disabled = false;
                } else {
                    document.getElementById('aiError').textContent = data.error || JSON.stringify(data.errors) || 'Generation failed.';
                    document.getElementById('aiError').classList.remove('hidden');
                }
            } catch (err) {
                document.getElementById('aiError').textContent = 'Network error: ' + err.message;
                document.getElementById('aiError').classList.remove('hidden');
            } finally {
                document.getElementById('aiLoading').classList.add('hidden');
                document.getElementById('btnGenerate').disabled = false;
            }
        }

        async function submitAICreate(e) {
            e.preventDefault();
            if (!generatedContent) { alert('Generate content first.'); return; }

            const eventId = document.getElementById('ai_event_id').value;
            const scheduledAt = prompt('Schedule for (YYYY-MM-DD HH:mm):', new Date(Date.now() + 3600000).toISOString().slice(0,16).replace('T',' '));
            if (!scheduledAt) return;

            document.getElementById('btnSchedule').disabled = true;

            try {
                const resp = await fetch(`/organizer/events/${eventId}/posts/ai/auto-schedule`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                    body: JSON.stringify({
                        platforms: ['linkedin'],
                        content: { linkedin: { text: generatedContent } },
                        scheduled_at: scheduledAt,
                    })
                });

                const data = await resp.json();

                if (resp.ok && data.success) {
                    alert(data.message);
                    closeAICreateModal();
                    window.location.reload();
                } else {
                    alert(data.error || JSON.stringify(data.errors) || 'Failed to schedule.');
                    document.getElementById('btnSchedule').disabled = false;
                }
            } catch (err) {
                alert('Network error: ' + err.message);
                document.getElementById('btnSchedule').disabled = false;
            }
        }
    </script>
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
<?php /**PATH C:\xampp\htdocs\vm\events-domain\resources\views/organizer/social/posts-index.blade.php ENDPATH**/ ?>