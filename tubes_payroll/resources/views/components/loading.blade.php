<div id="global-loader" class="w-full min-h-screen bg-[#f1f5f9] flex overflow-hidden">

    <aside class="w-72 fixed h-full z-50 p-8 bg-[#020617] overflow-hidden flex flex-col justify-between">
        <i class="fas fa-cog gear-rotate absolute -right-12 -top-12 text-[220px] text-white pointer-events-none"></i>
        <i class="fas fa-wrench gear-rotate absolute -left-10 bottom-40 text-[120px] text-white pointer-events-none" style="animation-duration: 40s; opacity: 0.02;"></i>

        <div class="relative z-10 flex flex-col h-full">
            <div class="flex items-center gap-3 mb-12 animate-pulse">
                <div class="w-10 h-10 bg-slate-800 skeleton rounded-2xl"></div>
                <div class="h-4 w-24 bg-slate-800 skeleton rounded-xl"></div>
            </div>

            <div class="space-y-8 flex-1 animate-pulse">
                <div class="space-y-3">
                    <div class="h-3 w-16 bg-slate-800 skeleton rounded-xl mb-4"></div>
                    <div class="h-11 bg-slate-800 skeleton rounded-2xl w-full"></div>
                </div>

                <div class="space-y-3">
                    <div class="h-3 w-24 bg-slate-800 skeleton rounded-xl mb-4"></div>
                    <div class="h-11 bg-slate-800 skeleton rounded-2xl w-full"></div>
                    <div class="h-11 bg-slate-800 skeleton rounded-2xl w-full"></div>
                    <div class="h-11 bg-slate-800 skeleton rounded-2xl w-full"></div>
                </div>
            </div>

            <div class="pt-6 border-t border-white/5 mt-auto animate-pulse">
                <div class="flex items-center gap-3 bg-white/5 p-4 rounded-3xl">
                    <div class="w-10 h-10 bg-slate-800 skeleton rounded-2xl"></div>
                    <div class="flex-1 space-y-2">
                        <div class="h-3 w-24 bg-slate-800 skeleton rounded-xl"></div>
                        <div class="h-2 w-16 bg-slate-800 skeleton rounded-xl"></div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <div class="ml-72 flex-1 p-6 md:p-10 min-h-screen overflow-y-auto">

        @stack('loading')

        @if (!trim($__env->yieldPushContent('loading')))
            <div class="space-y-8 animate-pulse">
                
                <div class="flex justify-between items-center mb-6">
                    <div class="space-y-2">
                        <div class="h-4 skeleton rounded-lg w-40"></div>
                        <div class="h-2.5 skeleton rounded-lg w-24"></div>
                    </div>
                    <div class="w-48 h-12 skeleton rounded-[24px] hidden lg:block"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="h-28 skeleton rounded-2xl"></div>
                    <div class="h-28 skeleton rounded-2xl"></div>
                    <div class="h-28 skeleton rounded-2xl"></div>
                    <div class="h-28 skeleton rounded-2xl"></div>
                </div>

                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                    <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                        <div class="h-8 skeleton rounded-xl w-48"></div>
                        <div class="h-8 skeleton rounded-xl w-24"></div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="h-12 bg-slate-50 skeleton rounded-xl w-full"></div>
                        <div class="h-12 bg-slate-50 skeleton rounded-xl w-full"></div>
                        <div class="h-12 bg-slate-50 skeleton rounded-xl w-full"></div>
                        <div class="h-12 bg-slate-50 skeleton rounded-xl w-full"></div>
                    </div>
                </div>

            </div>
        @endif

    </div>

</div>