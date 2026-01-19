<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LibraryController extends Controller
{
    // Inventory Management
    public function index()
    {
        $books = Book::paginate(20);
        return view('admin.library.index', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'book_number' => 'nullable|string|unique:books,book_number',
            'quantity' => 'required|integer|min:1',
            'rack_no' => 'nullable|string',
        ]);

        Book::create($request->all());

        return redirect()->back()->with('success', 'Book added successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->back()->with('success', 'Book deleted successfully.');
    }

    // Circulation (Issue/Return)
    public function circulationIndex(Request $request)
    {
        $issues = BookIssue::with(['book', 'student.user', 'student.school_class'])
            ->whereNull('return_date')
            ->orderBy('due_date', 'asc')
            ->paginate(15);

        $classes = SchoolClass::all();

        return view('admin.library.circulation', compact('issues', 'classes'));
    }

    public function history(Request $request)
    {
        $history = BookIssue::with(['book', 'student.user', 'student.school_class'])
            ->orderBy('issue_date', 'desc')
            ->paginate(20);

        return view('admin.library.history', compact('history'));
    }

    public function issueBookCreate()
    {
        $books = Book::withCount([
            'book_issues as active_issues_count' => function ($query) {
                $query->whereNull('return_date');
            }
        ])->where('quantity', '>', 0)->get();
        $classes = SchoolClass::with('sections')->get();
        return view('admin.library.issue_create', compact('books', 'classes'));
    }

    public function issueBookStore(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'student_id' => 'required|exists:students,id',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $book = Book::findOrFail($request->book_id);
        $activeIssues = BookIssue::where('book_id', $book->id)->whereNull('return_date')->count();

        if ($activeIssues >= $book->quantity) {
            return redirect()->back()->withErrors(['book_id' => 'This book is not available for issue.']);
        }

        BookIssue::create([
            'book_id' => $request->book_id,
            'student_id' => $request->student_id,
            'issue_date' => now(),
            'due_date' => $request->due_date,
            'status' => 'issued',
        ]);

        return redirect()->route('admin.library.circulation')->with('success', 'Book issued successfully.');
    }

    public function returnBook(BookIssue $issue)
    {
        $issue->update([
            'return_date' => now(),
            'status' => 'returned',
            // Fine calculation logic could go here
            'fine' => 0
        ]);

        return redirect()->back()->with('success', 'Book returned successfully.');
    }
}
