<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post New Notice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-soft rounded-2xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('admin.notices.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div class="space-y-2">
                            <label for="title" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Notice
                                Title</label>
                            <input type="text" name="title" id="title" required placeholder="Important announcement..."
                                class="w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all duration-200">
                        </div>

                        <!-- Content -->
                        <div class="space-y-2">
                            <label for="content"
                                class="text-sm font-bold text-gray-700 uppercase tracking-wider">Content</label>
                            <textarea name="content" id="content" rows="6" required placeholder="Detailed message..."
                                class="w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all duration-200"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Target Role -->
                            <div class="space-y-2">
                                <label for="target_role"
                                    class="text-sm font-bold text-gray-700 uppercase tracking-wider">Target
                                    Audience</label>
                                <select name="target_role" id="target_role" required
                                    class="w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all duration-200">
                                    <option value="all">Everyone</option>
                                    <option value="teacher">Teachers Only</option>
                                    <option value="student">Students Only</option>
                                    <option value="parent" selected>Parents Only</option>
                                </select>
                            </div>

                            <!-- Publish Date -->
                            <div class="space-y-2">
                                <label for="publish_date"
                                    class="text-sm font-bold text-gray-700 uppercase tracking-wider">Publish
                                    Date</label>
                                <input type="date" name="publish_date" id="publish_date" required
                                    value="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all duration-200">
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit"
                                class="w-full py-4 bg-brand-600 text-white rounded-2xl font-bold text-lg shadow-lg shadow-brand-600/20 hover:bg-brand-700 hover:-translate-y-1 transition-all duration-300">
                                Publish Notice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>