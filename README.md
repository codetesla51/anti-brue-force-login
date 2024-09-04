# Anti-Brute Force Login Form

This project implements an anti-brute force login mechanism using PHP. The system tracks the number of failed login attempts from each IP address and blocks the IP after a certain threshold is reached.

## Features

- **IP Address Tracking**: The system captures the user's IP address during login attempts.
- **Login Attempt Limiting**: Limits the number of failed login attempts allowed per IP address.
- **Blocking Mechanism**: Blocks the IP address after exceeding the allowed number of login attempts.
- **Unblocking Mechanism**: After a predefined period, the IP address is automatically unblocked, allowing the user to attempt login again.
- **Object-Oriented PHP**: The project is built using Object-Oriented Programming principles for better structure and reusability.

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/codetesla51/anti-brute-force-login.git
