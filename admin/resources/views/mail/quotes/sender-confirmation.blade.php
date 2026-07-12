<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Quote Request Received</title>
</head>
<body style="margin:0; padding:0; background:#f4f7fb; font-family:Arial, Helvetica, sans-serif; color:#0f172a;">
<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#f4f7fb; padding:24px 12px;">
	<tr>
		<td align="center">
			<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px; background:#ffffff; border-radius:16px; overflow:hidden; border:1px solid #e2e8f0;">
				<tr>
					<td style="background:linear-gradient(135deg,#0f172a,#1e293b); padding:24px 28px; text-align:center;">
						<img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}" style="height:54px; width:auto; display:block; margin:0 auto 12px;">
						<p style="margin:0; font-size:13px; letter-spacing:1px; text-transform:uppercase; color:#bfdbfe;">Quote Confirmation</p>
						<h1 style="margin:8px 0 0; font-size:24px; line-height:1.3; color:#ffffff;">We received your request</h1>
					</td>
				</tr>

				<tr>
					<td style="padding:24px 28px;">
						<p style="margin:0 0 12px; font-size:15px; line-height:1.7; color:#334155;">Hello {{ $quote->contactName }},</p>
						<p style="margin:0 0 18px; font-size:15px; line-height:1.7; color:#334155;">
							Thank you for contacting {{ config('app.name') }}. Your quote request has been received successfully, and our team will reach out shortly.
						</p>

						<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px;">
							<tr>
								<td style="padding:16px 18px; font-size:14px; line-height:1.7; color:#0f172a;">
									<p style="margin:0 0 8px;"><strong>Company:</strong> {{ $quote->companyName }}</p>
									<p style="margin:0 0 8px;"><strong>Email:</strong> {{ $quote->email }}</p>
									<p style="margin:0;"><strong>Phone:</strong> {{ $quote->phone }}</p>
								</td>
							</tr>
						</table>

						<table role="presentation" cellpadding="0" cellspacing="0" style="margin-top:24px;">
							<tr>
								<td style="border-radius:10px; background:#00a1e0;">
									<a href="{{ url('/') }}" style="display:inline-block; padding:12px 18px; font-size:14px; font-weight:700; color:#ffffff; text-decoration:none;">Visit Our Website</a>
								</td>
							</tr>
						</table>

						<p style="margin:24px 0 0; font-size:14px; line-height:1.7; color:#334155;">
							Best regards,<br>
							<strong>{{ config('app.name') }} Team</strong>
						</p>
					</td>
				</tr>

				<tr>
					<td style="padding:16px 28px 24px; border-top:1px solid #e2e8f0;">
						<p style="margin:0; font-size:12px; color:#64748b;">You are receiving this email because you submitted a quote form on our website.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>