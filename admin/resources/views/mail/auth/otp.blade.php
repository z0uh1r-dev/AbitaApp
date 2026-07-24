<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Your verification code</title>
</head>
<body style="margin:0; padding:0; background:#f4f7fb; font-family:Arial, Helvetica, sans-serif; color:#0f172a;">
<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#f4f7fb; padding:24px 12px;">
	<tr>
		<td align="center">
			<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px; background:#ffffff; border-radius:16px; overflow:hidden; border:1px solid #e2e8f0;">
				<tr>
					<td style="background:linear-gradient(135deg,#00a1e0,#0284c7); padding:24px 28px; text-align:center;">
						<img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}" style="height:54px; width:auto; display:block; margin:0 auto 12px;">
						<p style="margin:0; font-size:13px; letter-spacing:1px; text-transform:uppercase; color:#dbeafe;">Sign-in verification</p>
						<h1 style="margin:8px 0 0; font-size:24px; line-height:1.3; color:#ffffff;">Your verification code</h1>
					</td>
				</tr>

				<tr>
					<td style="padding:24px 28px;">
						<p style="margin:0 0 16px; font-size:15px; line-height:1.6; color:#334155;">
							Use the code below to finish signing in to {{ config('app.name') }}. This code expires in {{ $expiresInMinutes }} minutes and can only be used once.
						</p>

						<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px;">
							<tr>
								<td style="padding:20px 18px; text-align:center;">
									<span style="font-size:36px; font-weight:700; letter-spacing:10px; color:#0f172a;">{{ $code }}</span>
								</td>
							</tr>
						</table>

						<p style="margin:16px 0 0; font-size:13px; line-height:1.6; color:#64748b;">
							If you did not attempt to sign in, you can safely ignore this email.
						</p>
					</td>
				</tr>

				<tr>
					<td style="padding:16px 28px 24px; border-top:1px solid #e2e8f0;">
						<p style="margin:0; font-size:12px; color:#64748b;">This message was sent by {{ config('app.name') }}.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
