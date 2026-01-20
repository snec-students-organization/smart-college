<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notice Board Management') }}
            </h2>
            <a href="{{ route('admin.notices.create') }}"
                class="px-4 py-2 bg-brand-600 text-white rounded-xl font-bold hover:bg-brand-700 transition shadow-lg shadow-brand-600/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Post New Notice
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-soft rounded-2xl border border-gray-100">
                <div class="p-6">
                    @if(session('success'))
                        <div
                            class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead>
                                <tr class="bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    <th class="px-6 py-4 text-left font-bold">Notice Info</th>
                                    <th class="px-6 py-4 text-left font-bold">Target Role</th>
                                    <th class="px-6 py-4 text-left font-bold">Publish Date</th>
                                    <th class="px-6 py-4 text-right font-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($notices as $notice)
                                    <tr class="hover:bg-gray-50/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900">{{ $notice->title }}</div>
                                            <div class="text-xs text-gray-500 mt-1 line-clamp-1">
                                                {{ Str::limit($notice->content, 60) }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold capitalize 
                                                    {{ $notice->target_role === 'all' ? 'bg-indigo-50 text-indigo-700' : '' }}
                                                    {{ $notice->target_role === 'parent' ? 'bg-amber-50 text-amber-700' : '' }}
                                                    {{ $notice->target_role === 'teacher' ? 'bg-emerald-50 text-emerald-700' : '' }}
                                                    {{ $notice->target_role === 'student' ? 'bg-sky-50 text-sky-700' : '' }}">
                                                {{ $notice->target_role }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-600">
                                            {{ $notice->publish_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('admin.notices.destroy', $notice) }}" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Are you sure you want to delete this notice?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-400 hover:text-red-600 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">No notices
                                            found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $notices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>