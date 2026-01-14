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
            'isbn' => 'nullable|string|unique:books,isbn',
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

    public function issueBookCreate() {
        $books = Book::where('quantity', '>', 0)->get(); // Should technically check available copies
        $classes = SchoolClass::with('sections')->get();
        return view('admin.library.issue_create', compact('books', 'classes'));
    }

    public function issueBookStore(Request $request) {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'student_id' => 'required|exists:students,id',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        // Check availability logic (simplified for now)
        // In real app, check count of BookIssue where return_date is null for this book_id vs Book->quantity

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
