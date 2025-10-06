<h2 style="font-family: Poppins, sans-serif; margin-bottom: 20px;">
    Weekly Academic Report Update for
    <span style="color: #2980b9;">{{ $student->full_name }}</span>
</h2>

<p style="font-family: Poppins, sans-serif; font-size: 15px;">
    Dear <strong>{{ $student->guardian->full_name }}</strong>,
</p>

<p style="font-family: Poppins, sans-serif; font-size: 15px;">
    We hope this message finds you well.
</p>

<p style="font-family: Poppins, sans-serif; font-size: 15px;">
    We would like to inform you of the recent academic progress of
    <strong>{{ $student->full_name }}</strong>. Please see the summary below:
</p>

<ul style="font-family: Poppins, sans-serif; font-size: 15px; list-style: none; padding: 0;">
    <li><em>Completed Activities:</em>
        <strong style="color: green;">{{ $completed }}</strong>
    </li>
    <li><em>Remaining Activities:</em>
        <strong style="color: red;">{{ $remaining }}</strong>
    </li>
</ul>

<p style="font-family: Poppins, sans-serif; font-size: 15px;">
    Thank you for your continued support and involvement in {{ $student->first_name }}’s learning journey.
    Should you have any questions or require further information, please do not hesitate to contact us.
</p>

<p style="font-family: Poppins, sans-serif; font-size: 15px;">
    Best regards,<br>
    <strong>Don Luis Hidalgo Memorial School</strong>
</p>
