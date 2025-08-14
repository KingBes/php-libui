// option
typedef struct uiInitOptions uiInitOptions;
struct uiInitOptions
{
    unsigned long long Size;
};
const char *uiInit(uiInitOptions *options);
void uiUninit(void);
void uiFreeInitError(const char *err);
void uiMain(void);
void uiMainSteps(void);
int uiMainStep(int wait);
void uiQuit(void);
void uiQueueMain(void (*f)(void *data), void *data);
void uiTimer(int milliseconds, int (*f)(void *data), void *data);
void uiOnShouldQuit(int (*f)(void *data), void *data);
void uiFreeText(char *text);

// control
typedef struct uiControl uiControl;
struct uiControl
{
    unsigned int Signature;
    unsigned int OSSignature;
    unsigned int TypeSignature;
    void (*Destroy)(uiControl *);
    unsigned long long (*Handle)(uiControl *);
    uiControl *(*Parent)(uiControl *);
    void (*SetParent)(uiControl *, uiControl *);
    int (*Toplevel)(uiControl *);
    int (*Visible)(uiControl *);
    void (*Show)(uiControl *);
    void (*Hide)(uiControl *);
    int (*Enabled)(uiControl *);
    void (*Enable)(uiControl *);
    void (*Disable)(uiControl *);
};
void uiControlDestroy(uiControl *);
unsigned long long uiControlHandle(uiControl *);
uiControl *uiControlParent(uiControl *);
void uiControlSetParent(uiControl *, uiControl *);
int uiControlToplevel(uiControl *);
int uiControlVisible(uiControl *);
void uiControlShow(uiControl *);
void uiControlHide(uiControl *);
int uiControlEnabled(uiControl *);
void uiControlEnable(uiControl *);
void uiControlDisable(uiControl *);
uiControl *uiAllocControl(unsigned long long n, unsigned int OSsig, unsigned int typesig, const char *typenamestr);
void uiFreeControl(uiControl *);
void uiControlVerifySetParent(uiControl *, uiControl *);
int uiControlEnabledToUser(uiControl *);
void uiUserBugCannotSetParentOnToplevel(const char *type);

// window
typedef struct uiWindow uiWindow;
char *uiWindowTitle(uiWindow *w);
void uiWindowSetTitle(uiWindow *w, const char *title);
void uiWindowContentSize(uiWindow *w, int *width, int *height);
void uiWindowSetContentSize(uiWindow *w, int width, int height);
int uiWindowFullscreen(uiWindow *w);
void uiWindowSetFullscreen(uiWindow *w, int fullscreen);
void uiWindowOnContentSizeChanged(uiWindow *w, void (*f)(uiWindow *, void *), void *data);
void uiWindowOnClosing(uiWindow *w, int (*f)(uiWindow *w, void *data), void *data);
int uiWindowBorderless(uiWindow *w);
void uiWindowSetBorderless(uiWindow *w, int borderless);
void uiWindowSetChild(uiWindow *w, uiControl *child);
int uiWindowMargined(uiWindow *w);
void uiWindowSetMargined(uiWindow *w, int margined);
uiWindow *uiNewWindow(const char *title, int width, int height, int hasMenubar);