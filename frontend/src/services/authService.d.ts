interface LoginCredentials {
  email: string
  password: string
}

interface LoginResponse {
  token: string
  user: any
}

interface AuthService {
  login(credentials: LoginCredentials): Promise<LoginResponse>
  logout(): Promise<void>
  me(): Promise<any>
  isAuthenticated(): boolean
}

declare const authService: AuthService
export default authService
